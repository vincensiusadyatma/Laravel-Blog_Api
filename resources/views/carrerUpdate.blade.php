<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Carrer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold mb-4 text-center">Update Carrer</h2>

     
        <form action="{{ route('carrers.update', $carrer->carrer_uuid) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold">Deskripsi:</label>
                <textarea name="description" rows="3" class="w-full border p-2 rounded" required>{{ old('deskripsi', $carrer->description) }}</textarea>
            </div>

     
            <div>
                <label class="block font-semibold">Gambar Saat Ini:</label>
                <img src="{{ asset('storage/' . $carrer->image_url) }}" alt="Carrer Image" class="w-full h-40 object-cover rounded border">
            </div>

          
            <div>
                <label class="block font-semibold">Upload Gambar Baru:</label>
                <input type="file" name="image" class="w-full border p-2 rounded">
            </div>

 
            <div>
                <label class="block font-semibold">Link:</label>
                <input type="url" name="link" value="{{ old('link', $carrer->link) }}" class="w-full border p-2 rounded">
            </div>

          
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Update</button>
        </form>
    </div>

</body>
</html>
