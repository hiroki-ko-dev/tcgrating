import React from 'react';
import ReactDOM from 'react-dom';

import html2canvas from 'html2canvas'
import defaultIcon from '../../../public/images/icon/default-icon-mypage.png';

(() => {

  let resumeJson = JSON.parse(document.getElementById('resumeJson').value);

  const gameUserChecks = () => {
    let checks = {};
    Object.keys(resumeJson.user.gameUser.gameUserChecks).forEach((key, index) => {
      checks[key] = true;
    });
  
    return checks;
  }

  // html2canvas で得られる URI を用いてダウンロードさせる関数
  // Ref: https://stackoverflow.com/questions/31656689/how-to-save-img-to-users-local-computer-using-html2canvas
  const saveAsImage = uri => {
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
    html2canvas(target).then(canvas => {
      const targetImgUri = canvas.toDataURL("img/jpg");
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
            id="download"
            className="btn site-color text-white rounded-pill btn-outline-secondary text-center"
            onClick={() => onClickExport()}>
            ダウンロード
          </button>
          <button id="edit" className="btn site-color text-white rounded-pill btn-outline-secondary text-center"
                  onClick={() => {location.href='/resume/' + resumeJson.user.id + '/edit'}}>
            編集する
          </button>
        </div>
      </div>
    );
  }

  const ResumeComponent = () => {

    return(
      <div id="resume" className="resume">
        <div className="content">

          <div className="header">
            <div className="title">ポケカ履歴書</div>
          </div>

          <div className="profile row">
            <div className="col-5">
              <img
                className="profileImage"
                src={"/storage/images/temp/twitter_game_3_user_" + resumeJson.user.id + ".jpg"}
              />
            </div>
            <div className="col-7">
              <div className="row">
                <div className="name col-12">
                  <div className="title">名前</div>
                  <div className="body">
                    {resumeJson.user.name}
                  </div>
                </div>
              </div>

              <div className="row">
                <div className="rate col-8">
                  <div className="title">ランキング</div>
                  <div className="body">
                    <span className="number">{resumeJson.user.gameUser.rank}</span>
                    <span className="staring">位</span>

                  </div>
                </div>
                <div className="gender col-4">
                  <div className="title">性別</div>
                  <div className="body">
                    {resumeJson.user.gender}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div className="like row">
            <div className="col-6">
              <div className="experience">
                <div className="title">ポケカ歴</div>
                <div className="body">
                  {resumeJson.user.gameUser.experience}
                </div>
              </div>
            </div>
            <div className="col-6">
              <div className="area">
                <div className="title">活動地域</div>
                <div className="body">
                  {resumeJson.user.gameUser.area}
                </div>
              </div>
            </div>
          </div>

          <div className="like row">

            <div className="col-6">
              <div className="pokemon">
                <div className="title">好きなポケモン</div>
                <div className="body">
                  {resumeJson.user.gameUser.preference}
                </div>
              </div>
            </div>

            <div className="col-6">
              <div className="regulation">
                <div className="title">レギュレーション</div>
                <div className="body">
                  <div className="row">
                    {gameUserChecks()[1]
                      ? <div className='standard'>✅ スタンダード</div>
                      : <div className='standard fontGrey'>⬜︎ スタンダード</div>
                    }
                    {gameUserChecks()[2]
                      ? <div className='legend'>✅ 殿堂</div>
                      : <div className='legend fontGrey'>⬜︎ 殿堂</div>
                    }
                  </div>
                  <div className="row">
                    {gameUserChecks()[3]
                      ? <div className='extra'>✅ エクストラ</div>
                      : <div className='extra fontGrey'>⬜︎ エクストラ</div>
                    }
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div className="playStyle row">
            <div className="title">プレイスタイル</div>
            <div className="body">
              <div className="row">
                <div className="col-4">
                  {gameUserChecks()[101]
                    ? <div className='left'>✅ リモート対戦募集！</div>
                    : <div className='left fontGrey'>⬜︎ リモート対戦募集！</div>
                  }
                </div>
                <div className="col-4">
                  {gameUserChecks()[102]
                    ? <div className='center'>✅ 大会に出たい！</div>
                    : <div className='center fontGrey'>⬜︎ 大会に出たい！</div>
                  }
                </div>
                <div className="col-4">
                  {gameUserChecks()[103]
                    ? <div className='right'>✅ 雑談がしたい！</div>
                    : <div className='right fontGrey'>⬜︎ 雑談がしたい！</div>
                  }
                </div>
              </div>
              <div className="row">
                <div className="col-4">
                  {gameUserChecks()[104]
                    ? <div className='left'>✅ 初心者です！</div>
                    : <div className='left fontGrey'>⬜︎ 初心者です！</div>
                  }
                </div>
                <div className="col-4">
                  {gameUserChecks()[105]
                    ? <div className='center'>✅ エンジョイ勢です！</div>
                    : <div className='center fontGrey'>⬜︎ エンジョイ勢です！</div>
                  }
                </div>
                <div className="col-4">
                  {gameUserChecks()[106]
                    ? <div className='right'>✅ ガチ勢です！</div>
                    : <div className='right fontGrey'>⬜︎ ガチ勢です！</div>
                  }
                </div>
              </div>
            </div>
          </div>

          <div className="freeSpace row">
            <div className="title">フリースペース</div>
            <div className="body">
              {resumeJson.user.body}
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
