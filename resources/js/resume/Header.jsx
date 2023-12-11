import React from 'react';
import html2canvas from 'html2canvas'
// import defaultIcon from '../../../public/images/icon/default-icon-mypage.png';

 // html2canvas で得られる URI を用いてダウンロードさせる関数
// Ref: https://stackoverflow.com/questions/31656689/how-to-save-img-to-users-local-computer-using-html2canvas
const saveAsImage = (uri) => {
  const downloadLink = document.createElement("a");
  if (typeof downloadLink.download === "string") {
    downloadLink.href = uri;
    // ファイル名
    downloadLink.download = "pokeka-resume.png";
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
  if (target) {
    html2canvas(target).then(canvas => {
      const targetImgUri = canvas.toDataURL("img/jpg");
      saveAsImage(targetImgUri);
    });
  }
}

export const Header = (props) => {
  const resumeJson = props.resumeJson
  return(
    <div className="col-12 page-header">
      <div className="header-font">
        ポケカ履歴書
      </div>
      <div className="ml-auto">
        {/* <button
          id="download"
          className="btn site-color text-white rounded-pill btn-outline-secondary text-center"
          onClick={() => onClickExport()}>
          ダウンロード
        </button> */}
        <button id="edit" className="btn site-color btn-outline-secondary text-light w-40 m-1"
            onClick={() => {location.href='/resume/' + resumeJson.user.id + '/edit'}}>
          編集する
        </button>
      </div>
    </div>
  );
}