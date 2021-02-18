import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ShelfComponent } from './shelf/shelf.component';
import { BookComponent } from './book/book.component';

const routes: Routes = [
  { path: '', redirectTo: '/shelf', pathMatch: 'full' },
  { path: 'shelf', component: ShelfComponent },
  { path: 'book/:id', component: BookComponent }
];


@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
