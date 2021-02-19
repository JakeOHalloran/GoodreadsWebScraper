import { Component, OnInit, Input } from '@angular/core';
import { Book } from '../book';
import { BooksService } from '../books.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-shelf',
  templateUrl: './shelf.component.html',
  styleUrls: ['./shelf.component.sass']
})
export class ShelfComponent implements OnInit {

  books: Book[] | undefined;
  authorPageLink: string = "https://www.goodreads.com/author/show/16866170.Brian_Quirke";

  constructor(private booksService: BooksService, private router: Router) {
    
  }

  ngOnInit() {
    this.getBooks();
  }

  getBooks(): void {
    this.books = this.booksService.getBooks(this.authorPageLink);
  }

  viewBook(id: number): void {
    this.router.navigate(['/book/', id]);
  }
}
