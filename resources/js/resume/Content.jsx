import React from 'react';

const gameUserChecks = (resumeJson) => {
    let checks = {};
    Object.keys(resumeJson.user.gameUser.gameUserChecks).forEach((key, index) => {
        checks[key] = true;
    });
    return checks;
}

export const Content = (props) => {
  const resumeJson = props.resumeJson;
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
                  {gameUserChecks(resumeJson)[1]
                      ? <div className='standard'>✅ スタンダード</div>
                      : <div className='standard fontGrey'>⬜︎ スタンダード</div>
                  }
                  {gameUserChecks(resumeJson)[2]
                      ? <div className='legend'>✅ 殿堂</div>
                      : <div className='legend fontGrey'>⬜︎ 殿堂</div>
                  }
                  </div>
                  <div className="row">
                  {gameUserChecks(resumeJson)[3]
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
                  {gameUserChecks(resumeJson)[101]
                  ? <div className='left'>✅ リモート対戦募集！</div>
                  : <div className='left fontGrey'>⬜︎ リモート対戦募集！</div>
                  }
              </div>
              <div className="col-4">
                  {gameUserChecks(resumeJson)[102]
                  ? <div className='center'>✅ 大会に出たい！</div>
                  : <div className='center fontGrey'>⬜︎ 大会に出たい！</div>
                  }
              </div>
              <div className="col-4">
                  {gameUserChecks(resumeJson)[103]
                  ? <div className='right'>✅ 雑談がしたい！</div>
                  : <div className='right fontGrey'>⬜︎ 雑談がしたい！</div>
                  }
              </div>
            </div>
            <div className="row">
              <div className="col-4">
                  {gameUserChecks(resumeJson)[104]
                  ? <div className='left'>✅ 初心者です！</div>
                  : <div className='left fontGrey'>⬜︎ 初心者です！</div>
                  }
              </div>
              <div className="col-4">
                  {gameUserChecks(resumeJson)[105]
                  ? <div className='center'>✅ エンジョイ勢です！</div>
                  : <div className='center fontGrey'>⬜︎ エンジョイ勢です！</div>
                  }
              </div>
              <div className="col-4">
                  {gameUserChecks(resumeJson)[106]
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
