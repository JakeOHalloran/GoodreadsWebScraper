import { Component, OnInit } from '@angular/core';
import { Book } from '../book';
import { BooksService } from '../books.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-shelf',
  templateUrl: './shelf.component.html',
  styleUrls: ['./shelf.component.sass']
})
export class ShelfComponent implements OnInit {

  books: Book[] = [];
  loading = false;
  authorPageLink: string = "https://www.goodreads.com/author/show/30702.Ian_Kershaw";
  limit: number = 50;

  constructor(private booksService: BooksService, private router: Router) { }

  ngOnInit() {
    this.getBooks();
  }

  getBooks(): void {
    // empty the book array incase it has already been filled with other books
    this.books.length = 0;

    this.loading = true;

    this.booksService.getBooks(this.authorPageLink, this.limit).subscribe( returnedBooks => {
      this.loading = false;
      this.books = returnedBooks;
      console.log(this.books);
    }, 
    err => {
      console.log("error: " + err);
    });
  }

  viewBook(bookPageURL: string): void {
    this.router.navigate(['/book/', bookPageURL]);
  }
}
