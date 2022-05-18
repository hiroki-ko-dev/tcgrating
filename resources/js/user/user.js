import React from 'react';
import ReactDOM from 'react-dom';

import html2canvas from 'html2canvas'
import defaultIcon from '../../../public/images/icon/default-icon-mypage.png';

(() => {

  let gameUserJson = JSON.parse(document.getElementById('gameUserJson').value);

  // html2canvas で得られる URI を用いてダウンロードさせる関数
  // Ref: https://stackoverflow.com/questions/31656689/how-to-save-img-to-users-local-computer-using-html2canvas
  const saveAsImage = uri => {
    const downloadLink = document.createElement("a");
    if (typeof downloadLink.download === "string") {
      downloadLink.href = uri;
      // ファイル名
      downloadLink.download = "component.png";
      // Firefox では body の中にダウンロードリンクがないといけないので一時的に追加
      document.body.appendChild(downloadLink);
      // ダウンロードリンクが設定された a タグをクリック
      downloadLink.click();
      // Firefox 対策で追加したリンクを削除しておく
      document.body.removeChild(downloadLink);
    } else {
      window.open(uri);
    }
  }

  const onClickExport = () => {
    // 画像に変換する component の id を指定
    const target = document.getElementById("resume");
    html2canvas(target).then(canvas => {
      const targetImgUri = canvas.toDataURL("img/png");
      saveAsImage(targetImgUri);
    });
  }

  const HeaderComponent = () => {

    return(
      <div className="col-12 page-header">
        <div className="header-font">
          ポケカ履歴書
        </div>
        <div className="ml-auto">
          <button
            className="btn site-color text-white rounded-pill btn-outline-secondary text-center"
            onClick={() => onClickExport()}>
            ダウンロード
          </button>
          <button className="btn site-color text-white rounded-pill btn-outline-secondary text-center"
                  onClick="location.href='/user/{{$user->id}}/edit'">
            編集する
          </button>
        </div>
      </div>
    );
  }


  const imageView = url => {

    console.log(gameUserJson);

    return(
      <div id="resume" className="resume">
        <div className="content">
          <div className="row justify-content-center">
            <div className="profile">
              <img
                className="qrcode-img"
                src={gameUserJson.user.twitter_image_url}
                crossOrigin="anonymous"
              />
            </div>
          </div>
        </div>
      </div>
    );
  }

  const ResumeComponent = () => {

    console.log(gameUserJson);

    return(
      <div id="resume" className="resume">
        <div className="content">
          <div className="row justify-content-center">
            <div className="profile">
              <img
                className="qrcode-img"
                src={gameUserJson.user.twitter_image_url}
                crossOrigin="anonymous"
              />
            </div>
          </div>

        </div>
      </div>
    );
  }


  const Component = () =>
    <div>
      <div className="d-flex flex-row align-items-center p-2">
        <HeaderComponent/>
      </div>
      <div className="d-flex flex-row align-items-center p-2">
        <ResumeComponent/>
      </div>
    </div>

  ReactDOM.render(
    <Component/>,
    document.getElementById('target-component')
  );

})();
