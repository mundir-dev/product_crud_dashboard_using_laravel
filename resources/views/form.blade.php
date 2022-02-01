@extends('welcome')
@section('content')
<div class="container">
  <div class="mt-5 p-3 bg-secondary text-light rounded-sm">
    <h4>Add New Product</h4>
  </div>
  
  <form action="{{ route('store_product') }}" method="post" class="mt-5" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="image">Product Image</label>
      <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror" required>
      @error('image')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
      @enderror
    </div>
    <div class="form-group">
      <label for="title">Product Title</label>
      <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
      @error('title')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
      @enderror
    </div>
    <div class="form-group">
      <label for="description">Description</label>
      <textarea name="description" id="description" rows="7" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
      @error('description')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
      @enderror
    </div>
    <div class="form-group">
      <label for="color">Colors</label>
      <textarea name="color" id="color" rows="4" class="form-control manage-item @error('color') is-invalid @enderror" dis_target="colorItem" required>{{ old('color') }}</textarea>
      <small id="colorHelp" class="form-text text-muted">Add a single space between each color.</small>
      <div class="items d-flex flex-wrap" id="colorItem"></div>
      @error('color')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
      @enderror
    </div>
    <div class="form-group">
      <label for="size">Size</label>
      <textarea name="size" id="size" rows="4" class="form-control manage-item @error('size') is-invalid @enderror" dis_target="sizeItem" required>{{ old('size')}}</textarea>
      <small id="sizeHelp" class="form-text text-muted">Add a single space between each size.</small>
      <div class="items d-flex flex-wrap" id="sizeItem"></div>
      @error('size')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
      @enderror
    </div>
    <div class="form-group text-right">
      <button type="submit" class="btn btn-primary">Save Product</button>
    </div>
  </form>
</div>
@endsection

@section('page_script')
<script>
  const setResultValue = e => {
    $('.manage-item').each((key, element) => {
      let text = $(element).val();
      let array = text.split(' ');
      let taget = $(`#${$(element).attr('dis_target')}`);
      taget.html('');
      $.each(array, (key, item) => { 
        taget.append(`<span class="badge badge-info p-2 m-1">${item}</span>`);
      });
    })
  }
  $( document ).ready(function() {
    setResultValue();
    $('.manage-item').on('input', setResultValue);
  });
</script>
@endsection
