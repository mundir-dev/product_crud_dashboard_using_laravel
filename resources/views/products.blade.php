@extends('welcome')
@section('content')
<div class="container">
    @if (session()->has('status'))
        <div class="alert alert-{{ session('status') !== "fail" ? "success" : "danger" }} mt-5">
        {{ session('status') !== "fail" ? session('status') : "Something went wrong" }}
        </div>
    @endif
    <table class="table mt-5">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Colors</th>
            <th scope="col">Size</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @if ($products->count())
                @php
                    $count = $products->firstItem();   
                @endphp
                @foreach ($products as $product)
                <tr>
                    <th scope="row">{{ $count++ }}</th>
                    <td><img src="{{ asset('images/' . $product->image) }}" class="img-fluid img-thumbnail" style="max-width: 130px"/></td>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->description }}</td>
                    <td>
                        <div class="d-flex flex-wrap">
                            @php
                                $colors = json_decode($product->color);
                            @endphp
                            @foreach ($colors as $color)
                            <span class="badge badge-info p-2 m-1">{{ $color }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td>
                    <div class="d-flex flex-wrap">
                        @php
                            $sizes = json_decode($product->size);
                        @endphp
                        @foreach ($sizes as $size)
                        <span class="badge badge-info p-2 m-1">{{ $size }}</span>
                        @endforeach
                    </div>
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('edit_product', $product->id) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('destroy_product', $product->id) }}" method="POST" class="mx-2">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            @else
            <tr>
                <td colspan="7">
                    <div class="alert alert-info" role="alert">No results found</div>
                </td>
            </tr>
            @endif
          
        </tbody>
      </table>

      @if ($products->count())
              <div class="d-flex flex-wrap justify-content-between mt-5">
                <p class="text-muted pr-3">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results</p>
                {{ $products->onEachSide(0)->links() }}
              </div>
     @endif
</div>
@endsection