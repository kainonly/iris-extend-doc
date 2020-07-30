import { Injectable } from '@angular/core';
import { ElectronService } from './electron.service';
import * as IORedis from 'ioredis';

@Injectable({
  providedIn: 'root'
})
export class RedisService {
  constructor(
    private electron: ElectronService
  ) {
  }

  create(id: string, options: IORedis.RedisOptions): void {
    this.electron.ipcRenderer.send('redis:create', {
      id,
      options
    });
  }

  config(id: string, options: string): any {
    return this.electron.ipcRenderer.sendSync('redis:config', {
      id,
      options
    });
  }

  select(id: string, options: number): any {
    return this.electron.ipcRenderer.sendSync('redis:select', {
      id,
      options
    });
  }

  scan(id: string, options?: IORedis.ScanStreamOption): any {
    return this.electron.ipcRenderer.sendSync('redis:scan', {
      id,
      options
    });
  }

  destory(id: string): void {
    this.electron.ipcRenderer.send('redis:destory', {
      id
    });
  }
}
