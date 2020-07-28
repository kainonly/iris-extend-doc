import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  template: `
    <nz-layout class="main">
      <app-nav></app-nav>
      <nz-content>
        <app-workspace></app-workspace>
      </nz-content>
    </nz-layout>
  `,
  styles: [`
    .main {
      height: 100%;
      width: 100%;
    }
  `]
})
export class AppComponent {
}
