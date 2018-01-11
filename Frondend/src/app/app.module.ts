import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpModule }    from '@angular/http';

import { AppComponent } from './app.component';
import { DeviceComponent } from './device/device.component';
import { DeviceListComponent } from './device-list/device-list.component';


@NgModule({
  declarations: [
    AppComponent,
    DeviceComponent,
    DeviceListComponent
  ],
  imports: [
    HttpModule,
    BrowserModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
