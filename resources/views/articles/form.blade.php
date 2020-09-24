@csrf
<div class="md-form">
  <label>タイトル</label>
  <input type="text" name="title" class="form-control" required value="{{ $article->title ?? old('title') }}">
  {{-- 式1 ?? 式2 という形 --}}
  {{-- 式1がnullでない場合は、式1が結果となる --}}
  {{-- 式1がnullである場合は、式2が結果となる --}}
  {{-- $article->titleがnullでない場合、$artile->titleが結果 --}}
  {{-- $article->titleがnullの場合、old('title')が結果 --}}
</div>
<div class="form-group">
  <article-tags-input
  >
  </article-tags-input>
</div>
<div class="form-group">
  <label></label>
  <textarea name="body" required class="form-control" rows="16" placeholder="本文">{{ $article->body ?? old('body') }}</textarea>
</div>
