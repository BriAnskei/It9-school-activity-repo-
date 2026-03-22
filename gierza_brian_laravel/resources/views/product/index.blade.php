<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Products</title>

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>



<div class="container">

  <h1>Products</h1>



  <form action="/products123" method="POST" class="product-form">

    @csrf

    

    <div class="form-group">

      <label for="name123">Name:</label>

      <input type="text" id="name" name="name123">

    </div>

    

    <div class="form-group">

      <label for="price123">Price:</label>

      <input type="text" id="price" name="price123">

    </div>

    

    <button type="submit" class="btn-submit">Save</button>

  </form>



  <hr>



  <table class="product-table">

    <thead>

      <tr>

        <th>ID</th>

        <th>Name</th>

        <th>Price</th>

      </tr>

    </thead>

    <tbody>

      @foreach($items as $item)

      <tr>

        <td>{{ $item->id }}</td>

        <td>{{ $item->name }}</td>

        <td>{{ $item->price }}</td>

      </tr>

      @endforeach

    </tbody>

  </table>

</div>

</body>
</html>