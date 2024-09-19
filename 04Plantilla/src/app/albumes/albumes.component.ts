import { Component, OnInit } from '@angular/core';
import { RouterLink } from '@angular/router';
import { SharedModule } from 'src/app/theme/shared/shared.module';
import { IAlbum } from '../Interfaces/ialbum';
import { AlbumesService } from '../Services/albumes.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-albumes',
  standalone: true,
  imports: [RouterLink, SharedModule],
  templateUrl: './albumes.component.html',
  styleUrl: './albumes.component.scss'
})
export class AlbumesComponent implements OnInit {
  listaAlbumes: IAlbum[] = [];

  constructor(private albumesService: AlbumesService) {}

  ngOnInit() {
    this.cargarAlbumes();
  }

  cargarAlbumes() {
    this.albumesService.todos().subscribe((data) => {
      console.log(data);
      this.listaAlbumes = data;
    });
  }

  eliminar(album_id: number) {
    Swal.fire({
      title: 'Álbumes',
      text: '¿Está seguro de que desea eliminar el álbum?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Eliminar Álbum'
    }).then((result) => {
      if (result.isConfirmed) {
        this.albumesService.eliminar(album_id).subscribe((data) => {
          Swal.fire('Álbumes', 'El álbum ha sido eliminado.', 'success');
          this.cargarAlbumes(); // Refrescar la tabla después de eliminar
        });
      }
    });
  }
}
