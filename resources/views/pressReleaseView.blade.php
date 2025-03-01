<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Press Release</title>
    <script>
        function addSection() {
            const container = document.getElementById('sections');
            const sectionIndex = container.children.length;
            
            const div = document.createElement('div');
            div.classList.add('section');
            div.innerHTML = `
                <hr>
                <label>Content:</label>
                <textarea name="contents[${sectionIndex}][content]" rows="3"></textarea>

                <label>Image:</label>
                <input type="file" name="contents[${sectionIndex}][image]">
                
                <button type="button" onclick="removeSection(this)">Remove Section</button>
            `;
            container.appendChild(div);
        }

        function removeSection(button) {
            button.parentElement.remove();
        }
    </script>
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

    <form action="{{ route('press-releases.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Date:</label>
        <input type="date" name="date" required>

        <label>Time:</label>
        <input type="time" name="time" required>

        <h3>Contents:</h3>
        <div id="sections"></div>
        <button type="button" onclick="addSection()">Add Section</button>

        <br><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
