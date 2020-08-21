import { Component, OnInit } from '@angular/core';
import { RedisService } from './common/redis.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html'
})
export class AppComponent implements OnInit {
  constructor(
    private redis: RedisService
  ) {
  }

  ngOnInit() {
    this.redis.create('mine', {
      host: 'dell'
    });
  }
}
