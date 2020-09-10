{{-- $errors->any() でエラーの有無を返す --}}
@if ($errors->any())
  <div class="card-text text-left alert alert-danger">
    <ul class="mb-0">
      {{-- エラーメッセージが1件以上ある場合は、allメソッドで全エラーメッセージの配列を取得 -- }}
      {{-- foreachで$errorに代入し、それを表示している --}}
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif