import { Component, OnInit, Input } from '@angular/core';
import { Book } from '../book';

import { ActivatedRoute } from '@angular/router';
import { Location } from '@angular/common';

import { BooksService } from '../books.service';

@Component({
  selector: 'app-book',
  templateUrl: './book.component.html',
  styleUrls: ['./book.component.sass']
})
export class BookComponent implements OnInit {

  constructor(private route: ActivatedRoute, private booksService: BooksService, private location: Location) { }

  ngOnInit(): void {
    this.getBookID();
  }
  
  // which book are we displaying?
  getBookID(): void {
    const id = +this.route.snapshot.paramMap.get('id')!;
  }

  // return to shelf
  goBack(): void {
    this.location.back();
  }

}
