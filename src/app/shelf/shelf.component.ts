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
  authorPageLink: string = "https://www.goodreads.com/author/show/1439.Malcolm_Gladwell?from_search=true&from_srp=true";

  constructor(private booksService: BooksService, private router: Router) {
    
  }

  ngOnInit() {
    this.getBooks();
  }

  getBooks(): void {
    this.booksService.getBooks(this.authorPageLink).subscribe( returnedBooks => {
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
