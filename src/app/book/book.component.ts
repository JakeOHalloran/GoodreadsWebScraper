import { Component, OnInit } from '@angular/core';
import { Book } from '../book';
import { BooksService } from '../books.service';
import { ActivatedRoute } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-book',
  templateUrl: './book.component.html',
  styleUrls: ['./book.component.sass']
})
export class BookComponent implements OnInit {

  book!: Book;
  loading = false;

  constructor(private route: ActivatedRoute, private booksService: BooksService, private location: Location) { }

  ngOnInit(): void {
    this.loading = true;

    this.booksService.getBook(this.getBookPageURL()).subscribe( returnedBook => {
      this.loading = false;
      this.book = returnedBook;
      console.log(this.book);
    }, 
    err => {
      console.log("error: " + err);
    });
  }
  
  // which book are we displaying?
  getBookPageURL(): string {
    const bookPageURL = this.route.snapshot.paramMap.get('bookPageURL')!;
    return bookPageURL;
  }

  // return to shelf
  goBack(): void {
    this.location.back();
  }

}
