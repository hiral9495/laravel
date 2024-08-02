<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Student Form - Laravel 9 CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>Add Student</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Student Name:</strong>
                        <input type="text" name="name" class="form-control" placeholder="Student Name" value={{ old('name') }}>
                        @error('name')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Student Email:</strong>
                        <input type="email" name="emails[]" class="form-control" placeholder="Student Email" value={{ old('email') }}>
                        <input type="email" name="emails[]" class="form-control" placeholder="Student Email" value={{ old('email') }}>
                        @error('email')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Student Email:</strong>
                        <input type="file" name="image" class="form-control" placeholder="Student Email">
                        @error('email')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Student Phone:</strong>
                        <input type="number" name="phone" class="form-control" placeholder="Student Phone">
                        @error('phone')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Student Address:</strong>
                        <input type="text" name="address" class="form-control" placeholder="Student Address">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="controls">
        <button class="add" onclick="addField()"><i class="fa fa-plus"></i>Add</button>
      </div>
                <button type="submit" class="btn btn-primary ml-3">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>
<script>
      function addField() {
        var container = document.getElementById("formfield");
        var div = document.createElement("div");
        div.className = "email-field";
        var input = document.createElement("input");
        input.type = "text";
        input.name = "emails[]";
        input.className = "text";
        input.size = 50;
        input.placeholder = "Email";
        var removeButton = document.createElement("button");
        removeButton.innerHTML = '<i class="fa fa-minus"></i> Remove';
        removeButton.type = "button";
        removeButton.onclick = function() {
          container.removeChild(div);
        };
        div.appendChild(input);
        div.appendChild(removeButton);
        container.appendChild(div);
      }
    </script>