import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';

const DeckPreview = () => {
  const [deckCode, setDeckCode] = useState('');
  const [deckUrl, setDeckUrl] = useState('');

  useEffect(() => {
    const deckCodeElement = document.getElementById('image_url') as HTMLInputElement;
    const deckUrlElement = document.getElementById('deckUrl') as HTMLInputElement;

    // 初期値を設定
    if (deckCodeElement) setDeckCode(deckCodeElement.value);
    if (deckUrlElement) setDeckUrl(deckUrlElement.value);

    // イベントリスナーを設定
    const handleInputChange = () => {
      if (deckCodeElement) setDeckCode(deckCodeElement.value);
      if (deckUrlElement) setDeckUrl(deckUrlElement.value);
    };

    if (deckCodeElement) deckCodeElement.addEventListener('input', handleInputChange);
    if (deckUrlElement) deckUrlElement.addEventListener('input', handleInputChange);

    // コンポーネントがアンマウントされるときにイベントリスナーを削除
    return () => {
      if (deckCodeElement) deckCodeElement.removeEventListener('input', handleInputChange);
      if (deckUrlElement) deckUrlElement.removeEventListener('input', handleInputChange);
    };
  }, []);

  return (
    deckCode && deckUrl  ? 
    <div>
      <img src={deckUrl + deckCode} style={{ maxWidth: '100%', height: 'auto' }} alt="ポケモンカードデッキコード" />
    </div>
    : <></>
  );
}

export default DeckPreview;

ReactDOM.render(
  <DeckPreview />,
  document.getElementById('target-component')
);
