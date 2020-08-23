import { Component, OnInit } from '@angular/core';
import { NzContextMenuService, NzDropdownMenuComponent } from 'ng-zorro-antd';
import { RedisService } from '../common/redis.service';
import { AppService } from '../common/app.service';

@Component({
  selector: 'app-workspace',
  templateUrl: './workspace.component.html',
  styleUrls: ['./workspace.component.scss']
})
export class WorkspaceComponent implements OnInit {
  select = '0';
  databases: any[] = [];
  matchValue: string;
  lists: any[] = [];
  checked = false;
  indeterminate = false;
  activeValue: any;

  renameVisible = false;
  renameValue = '';

  constructor(
    public app: AppService,
    private redis: RedisService,
    private nzContextMenuService: NzContextMenuService
  ) {
  }

  ngOnInit(): void {
    this.getDatabases();
    this.getLists();
  }

  getDatabases() {
    const result = this.redis.config('mine', 'databases');
    if (!result.error) {
      const [, databases] = result.data;
      for (let i = 0; i < databases; i++) {
        this.databases.push(i.toString());
      }
    }
  }

  getLists() {
    const result = this.redis.scan('mine', {
      match: this.matchValue
    });
    if (!result.error) {
      this.lists = result.data;
    }
  }

  selectChange(database: string) {
    const result = this.redis.select('mine', parseInt(database, 0));
    if (!result.error) {
      this.getLists();
    }
  }

  contextMenu($event: MouseEvent, menu: NzDropdownMenuComponent, data: any): void {
    this.activeValue = data;
    this.nzContextMenuService.create($event, menu);
  }

  renameOpen() {
    this.renameVisible = true;
    this.renameValue = '';
  }

  renameClose() {
    this.renameVisible = false;
    this.renameValue = '';
  }

  renameSubmit() {
    this.renameVisible = false;
    this.renameValue = '';
  }

  delete() {
    const result = this.redis.delete('mine', [this.activeValue.key]);
    if (!result.error) {
      this.getLists();
    }
  }
}
