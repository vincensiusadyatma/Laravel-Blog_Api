<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Press Release</title>
</head>
<body>
    <h2>Create Press Release</h2>
    
    @if ($errors->any())
        <div style="color: red;">
            <strong>Validation Errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <label>Caption:</label>
        <textarea name="caption" rows="3" required></textarea>

        <label>Image:</label>
        <input type="file" name="image" accept="image/*" required>
    

        <br><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
