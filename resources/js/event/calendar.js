// resources/js/fullcalendar.js
import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import momentPlugin from '@fullcalendar/moment'
import momentTimezonePlugin from '@fullcalendar/moment-timezone';
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import jaLocale from '@fullcalendar/core/locales/ja'
import ReactDOM from 'react-dom'
import React, { useState } from "react";
import moment from 'moment';

document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  const operatingStartTime = '09:00';
  const operatingEndTime   = '22:00';
  const jsonBookings = JSON.parse(document.getElementById('json_bookings').value);
  console.log(jsonBookings);
  const calendar = new Calendar(calendarEl, {

    plugins: [dayGridPlugin, momentPlugin, momentTimezonePlugin, timeGridPlugin, interactionPlugin],
    // plugins: [timeGridPlugin, momentTimezonePlugin, interactionPlugin],
    timeZone: 'Asia/Tokyo', // momentTimezonePlugin

    locale: jaLocale,

    defaultView: 'timeGridWeek',
    businessHours: true,
    editable: true, // イベントを編集するか
    draggable: true,
    allDaySlot: true, // 終日表示の枠を表示するか
    allDayText: '終日',
    eventDurationEditable: false, // イベント期間をドラッグしで変更するかどうか
    slotEventOverlap: false, // イベントを重ねて表示するか
    selectable: true,
    selectHelper: true,
    slotMinTime: operatingStartTime,
    slotMaxTime: operatingEndTime,
    slotDuration: '00:15:00',
    slotLabelInterval: '00:30',

    select: function(time) {
      // 日の枠内を選択したときの処理
      // document.getElementById( "start" ).value   = time['start'];
      // document.getElementById( "end" ).value     = time['end'];
      // document.getElementById( "all_day" ).value = time['allDay'];

      ReactDOM.render(
        <CalendarModal time={time} operatingStartTime={operatingStartTime} operatingEndTime={operatingEndTime}/>
        , document.getElementById('calendar-modal'))

      // calendar.addEvent({
      //   title: 'Business Events',
      //   start: time['start'],
      //   end: time['end']
      // })
    },
    eventClick: function(calEvent, jsEvent, view) {
      // イベントをクリックしたときの処理;
      console.log('イベントクリックのテスト');
      console.log(jsonBookings);
    },

    headerToolbar: {
      start: 'title',
      center: '',
      end: 'today prev,next'
    },
    // headerToolbar:{
    //   center: 'dayGridMonth,timeGridWeek,timeGridDay',
    // },

    slotLabelFormat: {
      hour: 'numeric',
      minute: '2-digit',
      omitZeroMinute: false,
      meridiem: 'short'
    },
    events: jsonBookings,
  });

  calendar.render();
});


// modalクラス
class CalendarModal extends React.Component{

  constructor(props) {
    super(props);
    let csrf_token = document.head.querySelector('meta[name="csrf-token"]').content;
    this.state = {
      open: true,
      csrf_token: csrf_token
    }
  }

  closeModal = () => {
    this.setState({
      open: false
    })
  }

  openModal = () => {
    this.setState({
      open: true
    })
  }

  render() {
    if(this.state.open) {

      let item_id = document.getElementById('item_id').value;

      let startDate   = moment(this.props.time['start']).format('YYYY-MM-DD');
      let endDate     = moment(this.props.time['end']).format('YYYY-MM-DD');
      let startTime   = moment(this.props.time['start']).format('HH:mm');
      let endTime     = moment(this.props.time['end']).format('HH:mm');
      // 営業時間
      let operatingStartTime = this.props.operatingStartTime;
      let operatingEndTime   = this.props.operatingEndTime;

      if(startTime === endTime){
        endDate = moment(endDate).add(-1, 'd').format('YYYY-MM-DD');
        startTime = operatingStartTime;
        endTime   = operatingEndTime;
      }

      return (
        <form action="/supplier/bookings" method="post">
          <input type="hidden" name="_token" value={ this.state.csrf_token } />
          <input type="hidden" name="item_id" value={item_id} />
          <div id="overlay">
            <div id="fullcalendar-modal">
              <div className="flex mb-1">
                <div className="mb-30 tx-14 tx-w500  w-20">
                  予約開始日
                </div>
                <div><input type="text" name="date" className="text-input" value={startDate}/></div>
              </div>
              <div className="flex mb-1">
                <div className="mb-30 tx-14 tx-w500  w-20">
                  予約終了日
                </div>
                <div><input type="text" name="date" className="text-input" value={endDate}/></div>
              </div>

              <div className="flex mb-1">
                <div className="mb-30 tx-14 tx-w500  w-20">開始時間</div>
                <div><input type="text" name="start_time" className="text-input" value={startTime}/></div>
              </div>

              <div className="flex mb-1">
                <div className="mb-30 tx-14 tx-w500  w-20">終了時間</div>
                <div><input type="text" name="end_time" className="text-input" value={endTime}/></div>
              </div>
              <div className="flex mb-1">
                <div>
                  <button type="submit" className="btn mr-5">保存</button>
                </div>
                <div>
                  <button className="btn" onClick={() => this.closeModal()}>Close</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      );
    }
    else{
      this.state.open = true;
      return null;
    }
  }
}



