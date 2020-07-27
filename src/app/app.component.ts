import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  tabs = [1, 2, 3];
  db = [];
  selectedIndex = 0;

  ngOnInit() {
    for (let i = 0; i < 50; i++) {
      this.db.push(i);
    }
  }

}
