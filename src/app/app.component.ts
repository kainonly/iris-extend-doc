import { Component, OnInit } from '@angular/core';
import { ElectronService } from './common/electron.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  tabs = [1, 2, 3];

  constructor(
    private electron: ElectronService
  ) {
  }

  ngOnInit() {
  }

  quit() {
    this.electron.remote.app.quit();
  }

}
