<h3>Import products</h3>

<p>
    Import products from a CSV file. The file must have the following columns: "Megnevezés", "Ár", "Kategória 1", "Kategória 2", "Kategória 3"
</p>

<form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="file">Choose file</label>
        <input type="file" name="file" id="file">
    </div>

    <button type="submit">Upload</button>
</form>

@if ($errors->any())
    <div>
        <strong>Error!</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div>
        <p>{{ session('success') }}</p>
        <p>File path: {{ session('file') }}</p>
    </div>
@endif
