import { Component, Input, OnInit } from '@angular/core';

import { Device } from './device.model'

@Component({
  selector: 'app-device',
  templateUrl: './device.component.html',
  styleUrls: ['./device.component.css']
})
export class DeviceComponent implements OnInit {
  @Input() device: Device;
  constructor() { }

  ngOnInit() {
  }

}
