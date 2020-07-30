import { Injectable } from '@angular/core';
import * as IORedis from 'ioredis';
import { ElectronService } from './electron.service';

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

  config(id: string, key: string): any {
    return this.electron.ipcRenderer.sendSync('redis:config', {
      id,
      key
    });
  }

  select(id: string, index: number): any {
    return this.electron.ipcRenderer.sendSync('redis:select', {
      id,
      index
    });
  }

  scan(id: string, options?: IORedis.ScanStreamOption): any {
    return this.electron.ipcRenderer.sendSync('redis:scan', {
      id,
      options
    });
  }

  delete(id: string, keys: any[]): any {
    return this.electron.ipcRenderer.sendSync('redis:delete', {
      id,
      keys
    });
  }

  destory(id: string): void {
    this.electron.ipcRenderer.send('redis:destory', {
      id
    });
  }
}
