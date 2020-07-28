import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  template: `
    <nz-layout class="main">
      <app-nav></app-nav>
      <app-workspace></app-workspace>
    </nz-layout>
  `
})
export class AppComponent {
}
