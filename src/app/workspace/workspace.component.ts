import { Component, OnInit } from '@angular/core';
import { NzContextMenuService, NzDropdownMenuComponent } from 'ng-zorro-antd';
import { RedisService } from '../common/redis.service';

@Component({
  selector: 'app-workspace',
  templateUrl: './workspace.component.html',
  styleUrls: ['./workspace.component.scss']
})
export class WorkspaceComponent implements OnInit {
  tabs = ['阿里云缓存', '腾讯云缓存', '华为云缓存'];
  checked = false;
  indeterminate = false;
  lists: any[] = [];
  menuData: any;

  constructor(
    private redis: RedisService,
    private nzContextMenuService: NzContextMenuService
  ) {
  }

  ngOnInit(): void {
    const result = this.redis.scan('mine');
    if (!result.error) {
      this.lists = result.data;
    }
  }

  closeTab(tab: string): void {
    this.tabs.splice(this.tabs.indexOf(tab), 1);
  }

  contextMenu($event: MouseEvent, menu: NzDropdownMenuComponent, data: any): void {
    this.menuData = data;
    this.nzContextMenuService.create($event, menu);
  }

}
