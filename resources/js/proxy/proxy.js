import React from 'react';
import ReactDOM from 'react-dom';

(() => {

  function ProxyUrl(props) {
    return (
      <input
        type="text"
        name={'proxy_url[' + props.proxy.id + ']'}
        className="form-control w-70 ml-2"
        value={props.proxy.url}
        placeholder="画像URLをセット"
        onChange={(e) =>
          props.changeProxy(e.target.value, props.proxy, 'url')}
        />
    );
  }
  function ProxyNumber(props) {
    return (
      <select
        name={'proxy_number[' + props.proxy.id + ']'}
        className="form-control w-30 ml-2"
        value={props.proxy.number}
        onChange={(e) =>
          props.changeProxy(e.target.value, props.proxy, 'number')}>
          <option value="0">0枚</option>
          <option value="1">1枚</option>
          <option value="2">2枚</option>
          <option value="3">3枚</option>
          <option value="4">4枚</option>
          <option value="5">5枚</option>
          <option value="6">6枚</option>
          <option value="7">7枚</option>
          <option value="8">8枚</option>
          <option value="9">9枚</option>
      </select>
    );
  }

  function ChangeProxyList(props) {
    const proxies = props.proxies.map((proxy,i) => {
      return (
        <div className="d-flex flex-row p-3" id="inputProxyBox" key={i}>
          <ProxyUrl
            proxy={proxy}
            changeProxy={props.changeProxy}
          />
          <ProxyNumber
            proxy={proxy}
            changeProxy={props.changeProxy}
          />
        </div>
      );
    });
    return (
      <div id="inputProxy" className="d-flex flex-row">
        {proxies}
      </div>
    );
  }

  function ViewProxyList(props) {
    const proxies = [];

    props.proxies.map((proxy) => {
        for (let i = 0; i < proxy.number; i++) {
          proxies.push(<img key={proxy.id + '_' + i} src={proxy.url} className="w-30" alt="画像URLが正しくありません"/>);
        }
    });

    return (
      <div className="col-6 mx-auto">
        <div id="inputProxy" className="d-flex">
        {proxies}
        </div>
      </div>
    );
  }

  class App extends React.Component {
    constructor() {
      super();
      this.state = {
        // state宣伝で最初の一回は普通に宣言
        proxies: [{id: 1, number: 0, url: ''}],
      };
      // 以降繰り返しのため、宣言をfor文で行う
      for(let i=2; i<10; i++){
        this.state.proxies.push({id: i, number: 0, url: ''})
      }

      // thisの定義のため？？
      this.changeProxy = this.changeProxy.bind(this);
    }

    changeProxy(value, proxy, operation){
      this.setState(prevState => {
        const proxies = prevState.proxies.map(proxy => {
          return {id: proxy.id, number: proxy.number, url: proxy.url};
        });
        const pos = proxies.map(proxy => {
          return proxy.id;
        }).indexOf(proxy.id);
        if(operation === 'url'){
          proxies[pos].url = value;
        }else if(operation === 'number'){
          proxies[pos].number = value;
        }
        return {
          proxies: proxies,
        };
      });
    }

    render() {
      return (
        <div>
          <ChangeProxyList
            proxies={this.state.proxies}
            changeProxy={this.changeProxy}
          />
          <div className="box p-3 mb-3">画像プレビュー　
            <input type="submit" name="pdf" value="印刷・PDF化"
              className="btn site-color text-white rounded-pill btn-outline-secondary text-center"/>
          </div>
          <ViewProxyList
            proxies={this.state.proxies}
          />
          <div className="box border-2">
            <h5 className="text-danger">使い方</h5>
            <div>①「画像アドレス」と「印刷枚数」を入力</div>
            <div>②「印刷・PDF化」ボタンを押す</div>
            <div>　※9種x9枚の最大81枚印刷可能</div>
          </div>
        </div>
      );
    }
  }

  ReactDOM.render(
    <App/>,
    document.getElementById('root')
  );
})();
