<div class="row justify-content-center  mb-0">
  @if(Auth::check())
    <button type="submit" class="btn site-color text-white rounded-pill btn-outline-secondary text-center pl-4 pr-4">
      {{ __('対戦を作成') }}
    </button>
  @else
    <div>
      <h5>Twitterログインしていないため対戦の作成ができません。</h5>
      <h5 class="font-weight-bold text-danger">「Twitterと連携」 からログインしくてださい。</h5>
    </div>
  @endif
</div>
