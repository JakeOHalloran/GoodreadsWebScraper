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
  authorPageLink: string = "https://www.goodreads.com/author/show/1439.Malcolm_Gladwell";
  limit = 50;

  constructor(private booksService: BooksService, private router: Router) {
    
  }

  ngOnInit() {
    //this.getBooks();
  }

  getBooks(): void {
    // empty the book array incase it has already been filled with other books
    this.books.length = 0;

    this.loading = true;

    this.booksService.getBooks(this.authorPageLink, this.limit).subscribe( returnedBooks => {
      this.loading = false;
      this.books = returnedBooks;
    }, 
    err => {
      console.log("error: " + err);
    });
  }

  viewBook(id: number): void {
    this.router.navigate(['/book/', id]);
  }
}
