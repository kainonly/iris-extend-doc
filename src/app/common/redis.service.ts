import { Injectable } from '@angular/core';
import { ElectronService } from './electron.service';
import * as IORedis from 'ioredis';

@Injectable({
  providedIn: 'root'
})
export class RedisService {
  Redis: typeof IORedis;

  constructor(
    private electron: ElectronService
  ) {
    this.Redis = electron.remote.require('ioredis');
  }
}
