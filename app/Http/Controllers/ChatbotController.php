<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chatbot;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use PhpOffice\PhpWord\IOFactory as WordReader;
use Smalot\PdfParser\Parser as PdfParser;
use Illuminate\Support\Str;

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

        // Upload profile photo to Cloudinary
        $chatbotPhotoUrl = null;
        if ($request->hasFile('chatbot_photo')) {
            $chatbotPhotoUrl = Cloudinary::upload($request->file('chatbot_photo')->getRealPath())->getSecurePath();
        }

        // Upload file to Cloudinary (PDF/DOCX)
        $uploadedFile = $request->file('reply_file');

        $cloudinaryUpload = Cloudinary::uploadFile(
            $uploadedFile->getRealPath(),
            [
                'resource_type' => 'raw',
                'folder' => 'chatbot_files', // optional: keep files organized
                'type' => 'upload',
                'public_id' => pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME)
            ]
        );

        // Get the public URL of the file
        $fileUrl = $cloudinaryUpload->getSecurePath();

        // Extract text
        $extractedText = $this->extractTextFromFile($uploadedFile);

        // Create chatbot
        Chatbot::create([
            'user_id'        => Auth::id(),
            'name'           => $request->name,
            'type'           => $request->type,
            'chatbot_photo'  => $chatbotPhotoUrl,
            'source_file'    => $fileUrl,
            'extracted_text' => Str::limit($extractedText, 50000), // Limit text to avoid memory issues
        ]);

        return redirect()->back()->with('success', 'Chatbot created successfully!');
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
