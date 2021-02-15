import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppComponent } from './app.component';
import { ShelfComponent } from './shelf/shelf.component';
import { BookComponent } from './book/book.component';

@NgModule({
  declarations: [			
    AppComponent,
    ShelfComponent,
      BookComponent
   ],
  imports: [
    BrowserModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
