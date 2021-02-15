import { Component, OnInit } from '@angular/core';
import { Book } from '../book';
import { BooksService } from '../books.service';

@Component({
  selector: 'app-shelf',
  templateUrl: './shelf.component.html',
  styleUrls: ['./shelf.component.sass']
})
export class ShelfComponent implements OnInit {

  books: Book[] = this.booksService.getBooks();
  selectedBook: Book | undefined;

  constructor(private booksService: BooksService) {
    this.getBooks();
  }

  ngOnInit() {
  }

  //onSelect(hero: Hero): void {
    //this.selectedHero = hero;
    //this.messageService.add(`HeroesComponent: Selected hero id=${hero.id}`);
  //}

  getBooks(): void {
    this.books = this.booksService.getBooks();
  }

  onSelect(book: Book): void {
    console.log(book);
    this.selectedBook = book;
  }
}
