import { Component, OnInit } from '@angular/core';
import { RedisService } from './common/redis.service';

@Component({
  selector: 'app-root',
  template: `
    <nz-layout class="main">
      <app-nav></app-nav>
      <app-workspace></app-workspace>
    </nz-layout>
  `
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
