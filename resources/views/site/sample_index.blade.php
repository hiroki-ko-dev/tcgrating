@extends('layout.common.common')

@section('title','TOP')

@section('description')
  <meta name="description" content="ポケモンカードのリモート対戦用のレーティングサイトです。ポケカのリモート対戦相手が見つからない、もっと強い相手と対戦したい!!という方はぜひ一目ご覧ください"/>
@endsection

@section('content')
<section class="lp1-banner">
  <div class="container">
    <div class="section-title">
      <h3>セミナー会場マッチング支援サービス</h3>
    </div>
    <div class="section-detail"><img src="images/lp1/banner_logo.png" srcset="images/lp1/banner_logo@2x.png 2x, images/lp1/banner_logo@3x.png 3x" alt="mice flatform">
      <p>
        目的に合った会場を簡単に検索・比較・予約が可能。<br>
        セミナー・イベント・学会など、会場予約が格段に楽になる！<span>
          登録料・利用料・手数料すべて無料！<br>
          プレミアム会員募集中！</span>
      </p>
      <button class="btn btn-primary">会員登録へ進む</button>
    </div>
  </div>
</section>
<section class="lp1-why">
  <div class="section-title">
    <h3>MICE Platform とは？</h3>
  </div>
  <div class="section-detail">
    <div class="container">
      <div class="why-desc">
        <ul class="list-unstyled">
          <li>
            <h4>Meeting<span>会議・研修・セミナー</span></h4>
          </li>
          <li>
            <h4>Incentive<span>報奨旅行</span></h4>
          </li>
          <li>
            <h4>Conference<span>国際会議・学会・大会</span></h4>
          </li>
          <li>
            <h4>Event<span>展示会・イベント・見本市</span></h4>
          </li>
        </ul>
      </div>
      <div class="why-text">
        の頭文字を取った造語です。<br>
        MICE Platformは、M・I・C・Eを開催する際に発生する<br>
        煩雑な業務を効率化する支援をさせていただきます。<br>
      </div>
      <div class="why-icon">
        <h5>
          より良いマッチングを実現<br>
          時間的コストを劇的に削減
        </h5>
        <ul class="list-unstyled">
          <li>
            <div class="why-icon--content">
              <h6>主催者</h6><img src="images/lp1/why/1.png" srcset="images/lp1/why/1@2x.png 2x, images/lp1/why/1@3x.png 3x" alt="主催者">
              <p>
                ・ちょうどよい会場が見つからない<br>
                ・細かい手続きが面倒
              </p>
            </div>
          </li>
          <li>
            <div class="why-icon--content">
              <h6>会場</h6><img src="images/lp1/why/2.png" srcset="images/lp1/why/1@2x.png 2x, images/lp1/why/1@3x.png 3x" alt="会場">
              <p>
                ・想定している顧客にリーチしづらい<br>
                ・業務が手間取るからか決定が遅い
              </p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section class="lp1-about">
  <div class="section-title">
    <h3>MICE Platform を使う主なメリット</h3>
  </div>
  <div class="section-detail">
    <div class="container">
      <h4>（登録無料プレミアム会員）</h4>
      <ul class="list-unstyled">
        <li>
          <p>おしゃれな会場から高級ホテルまで、<span>多種多様な会場</span>が見つかる</p>
        </li>
        <li>
          <p>比較表作成、相見積りも<span>1分で終了</span></p>
        </li>
        <li>
          <p>会場毎の折衝状況はMyPageで<span>カンタン把握</span></p>
        </li>
        <li>
          <p>複数の請求書をまとめて1枚に！<span>事務処理も楽々</span></p>
        </li>
        <li>
          <p>会場探しや運営に困った時は、<span>カリスマイベンター、会場ソムリエが支援</span></p>
        </li>
      </ul>
    </div>
  </div>
</section>
        <section class="lp1-pricetable">
          <div class="section-title">
            <h3>非会員・プレミアム会員の比較</h3>
          </div>
          <div class="section-detail">
            <div class="container"><table class="table table-bordered">
<tr>
<th colspan="2"></th>
<th><span>非会員</span></th>
<th><span>プレミアム会員</span><span>（無料）</span></th>
</tr>
<tr>
<td rowspan="4" class="border-rdlt"><span>基本機能</span></td>
<td><span>検索</span></td>
<td><img src="images/icons/check.png" srcset="images/icons/check@2x.png 2x, images/icons/check@3x.png 3x" alt="check"></td>
<td><img src="images/icons/check.png" srcset="images/icons/check@2x.png 2x, images/icons/check@3x.png 3x" alt="check"></td>
</tr>
<tr>
<td><span>比較表<br>作成・</span><span>ダウンロード</span></td>
<td><img src="images/icons/uncheck.png" srcset="images/icons/uncheck@2x.png 2x, images/icons/uncheck@3x.png 3x" alt="uncheck"></td>
<td><img src="images/icons/check.png" srcset="images/icons/check@2x.png 2x, images/icons/check@3x.png 3x" alt="check"></td>
</tr>
<tr>
<td><span>予約・仮予約</span></td>
<td><img src="images/icons/uncheck.png" srcset="images/icons/uncheck@2x.png 2x, images/icons/uncheck@3x.png 3x" alt="uncheck"></td>
<td><img src="images/icons/check.png" srcset="images/icons/check@2x.png 2x, images/icons/check@3x.png 3x" alt="check"></td>
</tr>
<tr>
<td>相見積もり依頼</td>
<td><img src="images/icons/uncheck.png" srcset="images/icons/uncheck@2x.png 2x, images/icons/uncheck@3x.png 3x" alt="uncheck"></td>
<td><img src="images/icons/check.png" srcset="images/icons/check@2x.png 2x, images/icons/check@3x.png 3x" alt="check"></td>
</tr>
<tr>
<td rowspan="4">マイページ</td>
<td>進捗管理</td>
<td><img src="images/icons/uncheck.png" srcset="images/icons/uncheck@2x.png 2x, images/icons/uncheck@3x.png 3x" alt="uncheck"></td>
<td><img src="images/icons/check.png" srcset="images/icons/check@2x.png 2x, images/icons/check@3x.png 3x" alt="check"></td>
</tr>
<tr>
<td>状況共有</td>
<td><img src="images/icons/uncheck.png" srcset="images/icons/uncheck@2x.png 2x, images/icons/uncheck@3x.png 3x" alt="uncheck"></td>
<td><img src="images/icons/check.png" srcset="images/icons/check@2x.png 2x, images/icons/check@3x.png 3x" alt="check"></td>
</tr>
<tr>
<td>メンバーと共有</td>
<td><img src="images/icons/uncheck.png" srcset="images/icons/uncheck@2x.png 2x, images/icons/uncheck@3x.png 3x" alt="uncheck"></td>
<td><img src="images/icons/check.png" srcset="images/icons/check@2x.png 2x, images/icons/check@3x.png 3x" alt="check"></td>
</tr>
<tr>
<td>簡単リピート予約</td>
<td><img src="images/icons/uncheck.png" srcset="images/icons/uncheck@2x.png 2x, images/icons/uncheck@3x.png 3x" alt="uncheck"></td>
<td><img src="images/icons/check.png" srcset="images/icons/check@2x.png 2x, images/icons/check@3x.png 3x" alt="check"></td>
</tr>
<tr>
<td rowspan="2" class="border-rdlb">コンシェルサービス</td>
<td>長期予約</td>
<td><img src="images/icons/uncheck.png" srcset="images/icons/uncheck@2x.png 2x, images/icons/uncheck@3x.png 3x" alt="uncheck"></td>
<td><img src="images/icons/check.png" srcset="images/icons/check@2x.png 2x, images/icons/check@3x.png 3x" alt="check"></td>
</tr>
<tr>
<td>会場探しを依頼</td>
<td><img src="images/icons/uncheck.png" srcset="images/icons/uncheck@2x.png 2x, images/icons/uncheck@3x.png 3x" alt="uncheck"></td>
<td class="border-rdrb"><img src="images/icons/check.png" srcset="images/icons/check@2x.png 2x, images/icons/check@3x.png 3x" alt="check"></td>
</tr>
</table>
              <div class="btn-wrap">
                <button class="btn btn-primary"><span>登録料・利用料・手数料無料</span><span>会員登録へ進む</span></button>
              </div>
            </div>
          </div>
        </section>
<section class="lp1-steps">
  <div class="section-title">
    <h3>サービス利用フロー</h3>
  </div>
  <div class="section-detail">
    <div class="steps-description">
      たったの7ステップですべての業務が完了！
      <br>
      細かい業務の一切はシステム内で処理が可能です！
    </div>
    <div class="steps-items--wrap">
      <div class="container">
        <ul class="list-unstyled steps-items">
          <li class="steps-item">
            <h4 class="steps-title"><span>会場検索</span></h4>
            <div class="steps-thumbnail"><img src="images/lp1/steps/1.png" srcset="images/lp1/steps/1@2x.png 2x,images/lp1/steps/1@3x.png 3x" alt="会場検索"></div>
          </li>
          <li class="steps-item">
            <h4 class="steps-title"><span>会場確認 / 仮予約</span></h4>
            <div class="steps-thumbnail"><img src="images/lp1/steps/2.png" srcset="images/lp1/steps/2@2x.png 2x,images/lp1/steps/2@3x.png 3x" alt="会場確認 / 仮予約"></div>
          </li>
          <li class="steps-item">
            <h4 class="steps-title"><span>会場比較</span></h4>
            <div class="steps-thumbnail"><img src="images/lp1/steps/3.png" srcset="images/lp1/steps/3@2x.png 2x,images/lp1/steps/3@3x.png 3x" alt="会場比較"></div>
          </li>
          <li class="steps-item">
            <h4 class="steps-title"><span>見積もり</span></h4>
            <div class="steps-thumbnail"><img src="images/lp1/steps/4.png" srcset="images/lp1/steps/4@2x.png 2x,images/lp1/steps/4@3x.png 3x" alt="見積もり"></div>
          </li>
          <li class="steps-item">
            <h4 class="steps-title"><span>会場と交渉</span></h4>
            <div class="steps-thumbnail"><img src="images/lp1/steps/5.png" srcset="images/lp1/steps/5@2x.png 2x,images/lp1/steps/5@3x.png 3x" alt="会場と交渉"></div>
          </li>
          <li class="steps-item">
            <h4 class="steps-title"><span>予約</span></h4>
            <div class="steps-thumbnail"><img src="images/lp1/steps/6.png" srcset="images/lp1/steps/6@2x.png 2x,images/lp1/steps/6@3x.png 3x" alt="予約"></div>
          </li>
          <li class="steps-item">
            <h4 class="steps-title"><span>決済</span></h4>
            <div class="steps-thumbnail"><img src="images/lp1/steps/7.png" srcset="images/lp1/steps/7@2x.png 2x,images/lp1/steps/7@3x.png 3x" alt="決済"></div>
          </li>
        </ul>
      </div>
    </div>
    <ul class="list-unstyled timelines-items">
      <li class="timelines-item">
        <div class="container">
          <div class="timelines-item--content">
            <div class="timelines-content">
              <h4 class="timelines-title"><span>会場検索</span></h4>
              <div class="timelines-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
            </div>
            <div class="timelines-thumbnail"><img src="images/lp1/timelines/1.jpg" srcset="images/lp1/timelines/1@2x.jpg 2x,images/lp1/timelines/1@3x.jpg 3x" alt="会場検索"></div>
            <div class="timelines-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
          </div>
        </div>
      </li>
      <li class="timelines-item">
        <div class="container">
          <div class="timelines-item--content">
            <div class="timelines-content">
              <h4 class="timelines-title"><span>会場確認 / 仮予約</span></h4>
              <div class="timelines-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
            </div>
            <div class="timelines-thumbnail"><img src="images/lp1/timelines/2.jpg" srcset="images/lp1/timelines/2@2x.jpg 2x,images/lp1/timelines/2@3x.jpg 3x" alt="会場確認 / 仮予約"></div>
            <div class="timelines-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
          </div>
        </div>
      </li>
      <li class="timelines-item">
        <div class="container">
          <div class="timelines-item--content">
            <div class="timelines-content">
              <h4 class="timelines-title"><span>会場比較</span></h4>
              <div class="timelines-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
            </div>
            <div class="timelines-thumbnail"><img src="images/lp1/timelines/3.jpg" srcset="images/lp1/timelines/3@2x.jpg 2x,images/lp1/timelines/3@3x.jpg 3x" alt="会場比較"></div>
            <div class="timelines-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
          </div>
        </div>
      </li>
      <li class="timelines-item">
        <div class="container">
          <div class="timelines-item--content">
            <div class="timelines-content">
              <h4 class="timelines-title"><span>見積もり</span></h4>
              <div class="timelines-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
            </div>
            <div class="timelines-thumbnail"><img src="images/lp1/timelines/4.jpg" srcset="images/lp1/timelines/4@2x.jpg 2x,images/lp1/timelines/4@3x.jpg 3x" alt="見積もり"></div>
            <div class="timelines-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
          </div>
        </div>
      </li>
      <li class="timelines-item">
        <div class="container">
          <div class="timelines-item--content">
            <div class="timelines-content">
              <h4 class="timelines-title"><span>会場と交渉</span></h4>
              <div class="timelines-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
            </div>
            <div class="timelines-thumbnail"><img src="images/lp1/timelines/5.jpg" srcset="images/lp1/timelines/5@2x.jpg 2x,images/lp1/timelines/5@3x.jpg 3x" alt="会場と交渉"></div>
            <div class="timelines-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
          </div>
        </div>
      </li>
      <li class="timelines-item">
        <div class="container">
          <div class="timelines-item--content">
            <div class="timelines-content">
              <h4 class="timelines-title"><span>予約</span></h4>
              <div class="timelines-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
            </div>
            <div class="timelines-thumbnail"><img src="images/lp1/timelines/6.jpg" srcset="images/lp1/timelines/6@2x.jpg 2x,images/lp1/timelines/6@3x.jpg 3x" alt="予約"></div>
            <div class="timelines-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
          </div>
        </div>
      </li>
      <li class="timelines-item">
        <div class="container">
          <div class="timelines-item--content">
            <div class="timelines-content">
              <h4 class="timelines-title"><span>決済</span></h4>
              <div class="timelines-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
            </div>
            <div class="timelines-thumbnail"><img src="images/lp1/timelines/7.jpg" srcset="images/lp1/timelines/7@2x.jpg 2x,images/lp1/timelines/7@3x.jpg 3x" alt="決済"></div>
            <div class="timelines-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
          </div>
        </div>
      </li>
    </ul>
    <div class="btn-wrap">
      <button class="btn btn-primary"><span>登録料・利用料・手数料無料</span><span>会員登録へ進む</span></button>
    </div>
  </div>
</section>
<section class="lp1-chat">
  <div class="container">
    <div class="section-title">
      <h3>利用者の声</h3>
    </div>
    <div class="section-detail">
      <ul class="list-unstyled chat-items">
        <li class="chat-item">
          <div class="chat-thumbnail"><img src="images/lp1/chat_thumbnail.png" srcset="images/lp1/chat_thumbnail@2x.png 2x, images/lp1/chat_thumbnail@3x.png 3x" alt="レビュータイトル"></div>
          <div class="chat-content">
            <h4 class="chat-title"><span>レビュータイトル</span><span>△△株式会社 〇〇広報</span>
              <time datetime="2019/11/30">2019/11/30</time>
            </h4>
            <div class="chat-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
            <time datetime="2019/11/30">2019/11/30</time>
          </div>
        </li>
        <li class="chat-item">
          <div class="chat-thumbnail"><img src="images/lp1/chat_thumbnail.png" srcset="images/lp1/chat_thumbnail@2x.png 2x, images/lp1/chat_thumbnail@3x.png 3x" alt="レビュータイトル"></div>
          <div class="chat-content">
            <h4 class="chat-title"><span>レビュータイトル</span><span>△△株式会社 〇〇広報</span>
              <time datetime="2019/11/30">2019/11/30</time>
            </h4>
            <div class="chat-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
            <time datetime="2019/11/30">2019/11/30</time>
          </div>
        </li>
        <li class="chat-item">
          <div class="chat-thumbnail"><img src="images/lp1/chat_thumbnail.png" srcset="images/lp1/chat_thumbnail@2x.png 2x, images/lp1/chat_thumbnail@3x.png 3x" alt="レビュータイトル"></div>
          <div class="chat-content">
            <h4 class="chat-title"><span>レビュータイトル</span><span>△△株式会社 〇〇広報</span>
              <time datetime="2019/11/30">2019/11/30</time>
            </h4>
            <div class="chat-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
            <time datetime="2019/11/30">2019/11/30</time>
          </div>
        </li>
        <li class="chat-item">
          <div class="chat-thumbnail"><img src="images/lp1/chat_thumbnail.png" srcset="images/lp1/chat_thumbnail@2x.png 2x, images/lp1/chat_thumbnail@3x.png 3x" alt="レビュータイトル"></div>
          <div class="chat-content">
            <h4 class="chat-title"><span>レビュータイトル</span><span>△△株式会社 〇〇広報</span>
              <time datetime="2019/11/30">2019/11/30</time>
            </h4>
            <div class="chat-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
            <time datetime="2019/11/30">2019/11/30</time>
          </div>
        </li>
        <li class="chat-item">
          <div class="chat-thumbnail"><img src="images/lp1/chat_thumbnail.png" srcset="images/lp1/chat_thumbnail@2x.png 2x, images/lp1/chat_thumbnail@3x.png 3x" alt="レビュータイトル"></div>
          <div class="chat-content">
            <h4 class="chat-title"><span>レビュータイトル</span><span>△△株式会社 〇〇広報</span>
              <time datetime="2019/11/30">2019/11/30</time>
            </h4>
            <div class="chat-description">ダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミーダミー</div>
            <time datetime="2019/11/30">2019/11/30</time>
          </div>
        </li>
      </ul>
      <div class="btn-wrap">
        <button class="btn btn-primary"><span>登録料・利用料・手数料無料</span><span>会員登録へ進む</span></button>
      </div>
    </div>
  </div>
</section>
<section class="lp1-qa">
  <div class="container">
    <div class="section-title">
      <h3>Q&A</h3>
    </div>
    <div class="section-detail">
      <div class="accordion" id="lp-qa">
        <div class="card">
          <div class="card-header" id="heading1">
            <h4>
              <button type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">質問の内容質問の内容質問の内容質問の内容質問の内容質問の内容</button>
            </h4>
          </div>
          <div class="collapse show" id="collapse1" aria-labelledby="heading1" data-parent="#lp-qa">
            <div class="card-body">回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー</div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" id="heading2">
            <h4>
              <button type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">質問の内容質問の内容質問の内容質問の内容質問の内容質問の内容</button>
            </h4>
          </div>
          <div class="collapse" id="collapse2" aria-labelledby="heading2" data-parent="#lp-qa">
            <div class="card-body">回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー</div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" id="heading3">
            <h4>
              <button type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">質問の内容質問の内容質問の内容質問の内容質問の内容質問の内容</button>
            </h4>
          </div>
          <div class="collapse" id="collapse3" aria-labelledby="heading3" data-parent="#lp-qa">
            <div class="card-body">回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー</div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" id="heading4">
            <h4>
              <button type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">質問の内容質問の内容質問の内容質問の内容質問の内容質問の内容</button>
            </h4>
          </div>
          <div class="collapse" id="collapse4" aria-labelledby="heading4" data-parent="#lp-qa">
            <div class="card-body">回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー</div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" id="heading5">
            <h4>
              <button type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">質問の内容質問の内容質問の内容質問の内容質問の内容質問の内容</button>
            </h4>
          </div>
          <div class="collapse" id="collapse5" aria-labelledby="heading5" data-parent="#lp-qa">
            <div class="card-body">回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー回答ダミー</div>
          </div>
        </div>
      </div>
      <div class="btn-wrap">
        <button class="btn btn-primary"><span>登録料・利用料・手数料無料</span><span>会員登録へ進む</span></button>
      </div>
    </div>
  </div>
</section>

@endsection

@include('layout.common.header')
@include('layout.common.footer')
