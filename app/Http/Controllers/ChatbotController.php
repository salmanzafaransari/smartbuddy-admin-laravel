<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chatbot;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use PhpOffice\PhpWord\IOFactory as WordReader;
use Smalot\PdfParser\Parser as PdfParser;
use Illuminate\Support\Str;
use Cloudinary\Api\Upload\UploadApi;
use App\Models\ChatbotApi;

class chatbotController extends Controller
{
    public function index()
    {
        $chatbots = Chatbot::where('user_id', Auth::id())->latest()->get();
        return view('chatbot.index', compact('chatbots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'type'           => 'required|string|max:255',
            'chatbot_photo'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'reply_file'     => 'required|mimes:pdf,doc,docx|max:10240', // Max 10MB
        ]);

        $chatbotPhotoUrl = null;
        $chatbotPhotoPublicId = null;

        if ($request->hasFile('chatbot_photo')) {
            $uploadResponse = Cloudinary::upload(
                $request->file('chatbot_photo')->getRealPath(),
                ['folder' => 'chatbot_images']
            );
            $chatbotPhotoUrl = $uploadResponse->getSecurePath();
            $chatbotPhotoPublicId = $uploadResponse->getPublicId(); // Store this!
        }

        $uploadedFile = $request->file('reply_file');
        $docUploadResponse = Cloudinary::uploadFile(
            $uploadedFile->getRealPath(),
            [
                'resource_type' => 'raw',
                'folder' => 'chatbot_files',
                'type' => 'upload',
                'public_id' => pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME),
            ]
        );
        $fileUrl = $docUploadResponse->getSecurePath();
        $sourceFilePublicId = $docUploadResponse->getPublicId(); // Store this too!

        $extractedText = $this->extractTextFromFile($uploadedFile);

        Chatbot::create([
            'user_id'                 => Auth::id(),
            'name'                    => $request->name,
            'type'                    => $request->type,
            'chatbot_photo'           => $chatbotPhotoUrl,
            'chatbot_photo_public_id' => $chatbotPhotoPublicId,
            'source_file'             => $fileUrl,
            'source_file_public_id'   => $sourceFilePublicId,
            'extracted_text'          => Str::limit($extractedText, 50000),
        ]);

        return redirect()->back()->with('success', 'Chatbot created successfully!');
    }

    public function destroy($id)
    {
        $chatbot = Chatbot::findOrFail($id);

        try {
            $uploadApi = new UploadApi();

            // 1. Delete Chatbot Image (if any)
            if ($chatbot->chatbot_photo_public_id) {
                $uploadApi->destroy($chatbot->chatbot_photo_public_id);
            }

            // 2. Delete Source File (PDF/DOCX)
            if ($chatbot->source_file_public_id) {
                $uploadApi->destroy($chatbot->source_file_public_id, ['resource_type' => 'raw']);
            }
        } catch (\Exception $e) {
            \Log::error('Cloudinary deletion error: ' . $e->getMessage());
        }

        // Delete Chatbot from database
        $chatbot->delete();

        return redirect()->back()->with('success', 'Chatbot deleted successfully.');
    }
    public function edit($id)
    {
        $chatbot = Chatbot::findOrFail($id);
        return response()->json($chatbot);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'chatbot_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $chatbot = Chatbot::findOrFail($id);

        // Image replacement
        if ($request->hasFile('chatbot_photo')) {
            if ($chatbot->chatbot_photo_public_id) {
                (new UploadApi())->destroy($chatbot->chatbot_photo_public_id);
            }
            $upload = \Cloudinary::upload($request->file('chatbot_photo')->getRealPath(), ['folder' => 'chatbot_images']);
            $chatbot->chatbot_photo = $upload->getSecurePath();
            $chatbot->chatbot_photo_public_id = $upload->getPublicId();
        }

        $chatbot->name = $request->name;
        $chatbot->type = $request->type;
        $chatbot->save();

        return redirect()->back()->with('success', 'Chatbot updated successfully.');
    }

    public function configure($id)
    {
        $chatbot = Chatbot::with('api')->findOrFail($id);
        return view('chatbot.configure', compact('chatbot'));
    }


   public function saveBot(Request $request)
    {
        $validated = $request->validate([
            'chatbot_id'    => 'required|integer',
            'primary_color' => 'required',
            'user_bubble'   => 'required',
            'bot_bubble'    => 'required',
            'position_x'    => 'required|in:left,right',
            'position_y'    => 'required|in:top,bottom',
            'offset_x'      => 'required|numeric',
            'offset_y'      => 'required|numeric',
        ]);

        // Fetch chatbot details from DB
        $chatbotId = $request->chatbot_id;
        $chatbot = Chatbot::select('id', 'name', 'chatbot_photo')
            ->with(['api' => function ($query) {
                $query->select('chatbot_id', 'access_token');
            }])
            ->findOrFail($validated['chatbot_id']);

        $accessToken = $chatbot->api->access_token;
        $botName     = $chatbot->name;
        $avatarUrl   = $chatbot->chatbot_photo;

        // Replace placeholders in CSS
        $cssTemplate = file_get_contents(resource_path('views/chatbot/chat-widget.css'));
        $css = str_replace(
            ['{{CHAT_POSITION_X}}', '{{CHAT_POSITION_Y}}', '{{CHAT_OFFSET_X}}', '{{CHAT_OFFSET_Y}}', '{{PRIMARY_COLOR}}', '{{USER_BUBBLE}}', '{{BOT_BUBBLE}}', '{{AVATAR_URL}}'],
            [$validated['position_x'], $validated['position_y'], $validated['offset_x'], $validated['offset_y'], $validated['primary_color'], $validated['user_bubble'], $validated['bot_bubble'], $avatarUrl],
            $cssTemplate
        );

        // Replace placeholders in JS
        $jsTemplate = file_get_contents(resource_path('views/chatbot/chat-widget.js'));
        $js = str_replace(
            ['{{ACCESS_TOKEN}}', '{{BOT_NAME}}', '{{BOT_IMAGE}}'],
            [$accessToken, $botName, $avatarUrl],
            $jsTemplate
        );

        // Create ZIP for download
        $zipPath = storage_path('app/chatbot_custom.zip');
        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
            $zip->addFromString('chat-widget.css', $css);
            $zip->addFromString('chat-widget.js', $js);
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    private function extractTextFromFile($file)
    {
        $mime = $file->getMimeType();

        if (Str::contains($mime, 'pdf')) {
            try {
                $parser = new PdfParser();
                $pdf = $parser->parseFile($file->getPathname());
                return $pdf->getText();
            } catch (\Exception $e) {
                return '';
            }
        } elseif (Str::contains($mime, 'word')) {
            try {
                $phpWord = WordReader::load($file->getPathname());
                $text = '';
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText() . "\n";
                        }
                    }
                }
                return $text;
            } catch (\Exception $e) {
                return '';
            }
        }

        return '';
    }
}
