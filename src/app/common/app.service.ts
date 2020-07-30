import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class AppService {
  instance = ['阿里云缓存', '腾讯云缓存', '华为云缓存'];

  constructor() {
  }

  closeInstance(id: string): void {
    this.instance.splice(this.instance.indexOf(id), 1);
  }
}
