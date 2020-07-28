import { Component, OnInit } from '@angular/core';
import { ElectronService } from '../common/electron.service';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.scss']
})
export class NavComponent implements OnInit {

  constructor(
    private electron: ElectronService
  ) {
  }

  ngOnInit(): void {
  }

  quit() {
    this.electron.remote.app.quit();
  }
}
