<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BlogController extends Controller
{
    public function HhomeBlogList()
    {
        $blogs = Blog::latest()->paginate(5); // pagination optional
        $recentPosts = Blog::latest()->take(8)->get();

        return view('frontend.bloglist', compact('blogs', 'recentPosts'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'author'           => 'nullable|string|max:255',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string|max:255',
            'status'           => 'nullable|boolean',
        ]);

        $imageUrl = null;
        $imagePublicId = null;

        // Upload image to Cloudinary (if provided)
        if ($request->hasFile('image')) {
            $uploadResponse = Cloudinary::upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'blog_images']
            );

            $imageUrl = $uploadResponse->getSecurePath();
            $imagePublicId = $uploadResponse->getPublicId();
        }

        // Generate slug (unique)
        $slug = Str::slug($request->title);
        $count = Blog::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        // Save blog
        $blog = Blog::create([
            'title'            => $request->title,
            'slug'             => $slug,
            'content'          => $request->content,
            'image'            => $imageUrl,
            'author'           => $request->author ?? auth()->user()->name,
            'meta_title'       => $request->meta_title ?? $request->title,
            'meta_description' => $request->meta_description ?? Str::limit(strip_tags($request->content), 160),
            'meta_keywords'    => $request->meta_keywords,
            'status'           => $request->status ?? 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Blog created successfully!',
            'data'    => $blog,
        ]);
    }
    public function show($blogSlug)
    { 
        $blog = Blog::where('slug', $blogSlug)->first();

        if (!$blog) {
            abort(404); // show Laravel's 404 page
        }
        // Optionally get recent posts for sidebar
        $recentPosts = Blog::latest()->take(10)->get();

        return view('frontend.blogSingle', compact('blog','recentPosts'));
    }
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json($blog); // return JSON for Ajax
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $data = $request->only([
            'title', 'slug', 'author', 'content',
            'meta_title', 'meta_keywords', 'meta_description'
        ]);
        $data['status'] = $request->has('status') ? 1 : 0;
        if (empty($data['slug'])) {
            // If no slug given, generate from title
            $slug = Str::slug($request->title);
        } else {
            // Use given slug
            $slug = Str::slug($data['slug']);
        }
        // Check uniqueness excluding current blog
        $count = Blog::where('slug', 'LIKE', "{$slug}%")
                    ->where('id', '!=', $blog->id)
                    ->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $data['slug'] = $slug;

        if ($request->hasFile('image')) {
            if ($blog->image) {
                // delete old from cloudinary
                $urlParts = explode('/', $blog->image);
                $fileWithExt = end($urlParts);
                $folder = $urlParts[count($urlParts) - 2];
                $publicId = $folder . '/' . pathinfo($fileWithExt, PATHINFO_FILENAME);
                Cloudinary::destroy($publicId);
            }

            $upload = Cloudinary::upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'blog_images']
            );
            $data['image'] = $upload->getSecurePath();
        }

        $blog->update($data);
        return response()->json(['success' => true, 'blog' => $blog]);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->image) {
            // Extract public ID from Cloudinary URL
            $urlParts = explode('/', $blog->image);
            $fileWithExt = end($urlParts); // e.g. iylpg6nqpa3ofombywac.webp
            $folder = $urlParts[count($urlParts) - 2]; // e.g. blog_images
            $publicId = $folder . '/' . pathinfo($fileWithExt, PATHINFO_FILENAME);
            // Delete from Cloudinary
            try {
                Cloudinary::destroy($publicId);
            } catch (\Exception $e) {
                \Log::error("Cloudinary deletion failed: " . $e->getMessage());
            }
        }

        // Delete blog from DB
        $blog->delete();

        return response()->json(['success' => true]);
    }

    public function createBlog(){
        return view('admin.createBlog');
    }
    public function adminBlogList(){
        return view('admin.listBlog');
    }
    public function getBlogsAdmin(){
        $blogs = Blog::select('id', 'title', 'image', 'created_at')
        ->orderBy('created_at', 'desc')
        ->get();
        return response()->json(['data' => $blogs]);
    }
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            try {
                $uploadedFileUrl = Cloudinary::upload(
                    $request->file('upload')->getRealPath(),
                    [
                        'folder' => 'blogs',
                        'resource_type' => 'image'
                    ]
                )->getSecurePath();

                return response()->json([
                    'uploaded' => true,
                    'url' => $uploadedFileUrl
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'uploaded' => false,
                    'error' => ['message' => $e->getMessage()]
                ], 500);
            }
        }

        return response()->json([
            'uploaded' => false,
            'error' => ['message' => 'No file uploaded']
        ], 400);
    }

}
