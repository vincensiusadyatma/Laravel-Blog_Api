<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold mb-4 text-center">Update Gallery</h2>
        <form action="{{ route('gallery.update', $gallery->gallery_uuid) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            
            <!-- Caption -->
            <div>
                <label class="block font-semibold">Caption:</label>
                <textarea name="caption" rows="3" class="w-full border p-2 rounded" required>{{ old('caption', $gallery->caption) }}</textarea>
            </div>
            
            <!-- Current Image -->
            <div>
                <label class="block font-semibold">Current Image:</label>
                <img src="{{ asset('storage/' . $gallery->image_url) }}" alt="Gallery Image" class="w-full h-40 object-cover rounded border">
            </div>
            
            <!-- Upload New Image -->
            <div>
                <label class="block font-semibold">Upload New Image:</label>
                <input type="file" name="image" class="w-full border p-2 rounded">
            </div>
            
            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Update</button>
        </form>
    </div>
</body>
</html>
