<h3>Import products</h3>

<p>
    Import products from a CSV file. The file must have the following columns:
</p>
    <ul>
        <li>"Megnevezés"</li>
        <li>"Ár"</li>
        <li>"Kategória 1"</li>
        <li>"Kategória 2"</li>
        <li>"Kategória 3"</li>
</ul>

<p>
    Some improvements could be made if there was more time:
</p>
<ul>
    <li>A queue job to handle the import, for now execution time is just set to the maximum of 60 seconds</li>
    <li>Validation of file content</li>
    <li>Feedback about the progress</li>
    <li>Unit tests</li>
</ul>



<form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="file">Choose file</label>
        <input type="file" name="file" id="file">
    </div>

    <button type="submit">Upload</button>
</form>

<p>
    Total products in the system: {{ $totalProducts }}
</p>
<table>
    <thead>
    <tr>
        <th>Category</th>
        <th>Product count</th>
    </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->products_count }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

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
    </div>
@endif

@if (session('error'))
    <div>
        <p>{{ session('error') }}</p>
    </div>
@endif
