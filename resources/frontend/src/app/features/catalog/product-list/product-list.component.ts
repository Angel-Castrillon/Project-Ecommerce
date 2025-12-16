import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ProductCatalogService, CatalogFilters } from '../../../core/services/product-catalog.service';
import { CursorPage } from '../../../core/models/cursor-page';
import { Product } from '../../../core/models/products';

@Component({
  selector: 'app-product-list',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.scss'],
})
export class ProductListComponent implements OnInit {
  page: CursorPage<Product> | null = null;
  loading = false;
  error: string | null = null;

  filters: CatalogFilters = {
    per_page: 5,
    sort_by: 'id',
    sort_dir: 'asc',
  };

  constructor(private catalog: ProductCatalogService) {}

  ngOnInit(): void {
    this.load();
  }

  load(): void {
    this.loading = true;
    this.error = null;

    this.catalog.getCatalog(this.filters).subscribe({
      next: (res) => {
        this.page = res;
        this.loading = false;
      },
      error: () => {
        this.error = 'No se pudo cargar el catálogo.';
        this.loading = false;
      },
    });
  }

  next(): void {
    if (!this.page) return;

    this.loading = true;
    this.catalog.nextPage(this.page, this.filters).subscribe({
      next: (res) => {
        this.page = res;
        this.loading = false;
      },
      error: () => {
        this.error = 'No se pudo cargar la siguiente página.';
        this.loading = false;
      },
    });
  }

  prev(): void {
    if (!this.page) return;

    this.loading = true;
    this.catalog.prevPage(this.page, this.filters).subscribe({
      next: (res) => {
        this.page = res;
        this.loading = false;
      },
      error: () => {
        this.error = 'No se pudo cargar la página anterior.';
        this.loading = false;
      },
    });
  }
}
