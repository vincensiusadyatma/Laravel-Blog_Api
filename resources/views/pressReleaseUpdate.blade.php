<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Press Release</title>
    <script>
        function addContentSection() {
            let index = document.querySelectorAll('.content-section').length;
            let div = document.createElement('div');
            div.classList.add("content-section", "mb-4", "border", "p-4", "rounded");
            div.innerHTML = `
                <textarea name="contents[\${index}][content]" class="w-full p-2 border rounded"></textarea>
                <input type="file" name="contents[\${index}][image]" class="w-full p-2 border rounded mt-2">
            `;
            document.getElementById('content-sections').appendChild(div);
        }
    </script>
</head>
<body>
    <form action="{{ route('press-release.update', $pressRelease->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="title">Judul:</label>
        <input type="text" id="title" name="title" value="{{ $pressRelease->title }}" required>

        <label for="date">Tanggal:</label>
        <input type="date" id="date" name="date" value="{{ $pressRelease->date }}" required>

        <label for="time">Waktu:</label>
        <input type="time" id="time" name="time" value="{{ $pressRelease->time }}" required>

        <div id="content-sections">
            @foreach($pressRelease->contents as $content)
            <div class="content-section mb-4 border p-4 rounded">
                <input type="hidden" name="contents[{{ $loop->index }}][id]" value="{{ $content->id }}">
                <textarea name="contents[{{ $loop->index }}][content]" class="w-full p-2 border rounded">{{ $content->content }}</textarea>
                <input type="file" name="contents[{{ $loop->index }}][image]" class="w-full p-2 border rounded mt-2">
                @if($content->image_url)
                    <img src="{{ $content->image_url }}" class="w-24 mt-2">
                @endif
            </div>
            @endforeach
        </div>

        <button type="button" onclick="addContentSection()">Tambah Konten</button>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
