import { Component } from '@angular/core';

import { Http, Response, Headers } from '@angular/http';

import 'rxjs/add/operator/map'

import { Device } from './device/device.model'

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  data: any = null;
  devices = [];

  /*constructor() {
    this.devices = [
      new Device(
          'mahesh',
          'maheshmotots',
          '2018-01-11T07:48:29.094Z',
          'OFFLINE'
      ),

      new Device(
          'mahesh2',
          'maheshmotots2',
          '2018-01-11T07:48:29.094Z',
          'OFFLINE2'
      ),
      new Device(
          'mahesh3',
          'maheshmotots3',
          '2018-01-11T07:48:29.094Z',
          'OFFLINE3'
      )
    ];
  }*/
  constructor(private _http: Http){
    this.getDevices();
  }

  private getDevices() {
    return this._http.get('http://192.168.99.100:5000/app_dev.php/devices?deviceId=&order_direction=ASC&limit=25&page=1')
        .subscribe(data => {
          this.data = data.json();
          console.log(this.data.devices);
          for(let device of this.data.devices) {
            let dev:Device = new Device(device.device_id, device.device_label, device.last_reported_time);
            this.devices.push(dev);
          }
         // this.devices =  this.data.devices;
        });
  }
}
