import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { registerLocaleData } from '@angular/common';
import { NZ_I18N } from 'ng-zorro-antd/i18n';
import { zh_CN } from 'ng-zorro-antd/i18n';
import zh from '@angular/common/locales/zh';
import {
  NzCardModule,
  NzDividerModule, NzDropDownModule,
  NzIconModule,
  NzLayoutModule,
  NzMenuModule,
  NzTableModule,
  NzTabsModule,
  NzTagModule
} from 'ng-zorro-antd';

registerLocaleData(zh);

import { AppComponent } from './app.component';
import { NavComponent } from './nav/nav.component';
import { WorkspaceComponent } from './workspace/workspace.component';

import { AppService } from './common/app.service';
import { ElectronService } from './common/electron.service';
import { RedisService } from './common/redis.service';

@NgModule({
  declarations: [
    AppComponent,
    NavComponent,
    WorkspaceComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpClientModule,
    BrowserAnimationsModule,
    NzIconModule,
    NzLayoutModule,
    NzMenuModule,
    NzTabsModule,
    NzCardModule,
    NzDividerModule,
    NzTableModule,
    NzTagModule,
    NzDropDownModule
  ],
  providers: [
    AppService,
    ElectronService,
    RedisService,
    { provide: NZ_I18N, useValue: zh_CN }
  ],
  bootstrap: [AppComponent]
})
export class AppModule {
}
