<div class="row justify-content-center  mb-0">
  @auth
    <input type="submit" name="save" class="btn site-color text-white rounded-pill btn-outline-secondary text-center pl-4 pr-4" value="対戦を作成・編集" onClick="return requestConfirm();">
  @else
    <div>
      <h5>Twitterログインしていないため対戦の作成ができません。</h5>
      <h5 class="font-weight-bold text-danger">「Twitterと連携」 からログインしくてださい。</h5>
    </div>
  @endif
</div>
