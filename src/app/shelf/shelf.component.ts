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

  books: Book[] = this.booksService.getBooks();

  constructor(private booksService: BooksService, private router: Router) {
    this.getBooks();
  }

  ngOnInit() {
  }

  getBooks(): void {
    this.books = this.booksService.getBooks();
  }

  viewBook(id: number): void {
    this.router.navigate(['/book/', id]);
  }
}
