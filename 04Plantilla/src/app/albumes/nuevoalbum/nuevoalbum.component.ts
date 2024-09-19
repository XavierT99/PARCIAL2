import { Component, OnInit } from '@angular/core';
import { AbstractControl, FormControl, FormGroup, ReactiveFormsModule, ValidationErrors, Validators } from '@angular/forms';
import { AlbumsService } from 'src/app/Services/albums.service'; // Servicio para manejar álbumes
import { IAlbum } from 'src/app/Interfaces/ialbum'; // Interface para el modelo de álbum
import { CommonModule } from '@angular/common';
import Swal from 'sweetalert2';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-nuevoalbum',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule],
  templateUrl: './nuevoalbum.component.html',
  styleUrls: ['./nuevoalbum.component.scss']
})
export class NuevoAlbumComponent implements OnInit {
  // Formulario reactivo para la creación o edición del álbum
  frm_Album = new FormGroup({
    titulo: new FormControl('', Validators.required),
    genero: new FormControl('', Validators.required),
    anio_lanzamiento: new FormControl('', [Validators.required, Validators.min(1900)]),
    discografica: new FormControl('', Validators.required)
  });

  idAlbum = 0;
  titulo = 'Nuevo Álbum'; // Título del componente (para saber si es nuevo o edición)

  constructor(
    private albumServicio: AlbumsService, // Servicio para manejar las operaciones CRUD de álbumes
    private navegacion: Router,
    private ruta: ActivatedRoute
  ) {}

  ngOnInit(): void {
    this.idAlbum = parseInt(this.ruta.snapshot.paramMap.get('idAlbum')); // Obtiene el ID del álbum si es una edición
    if (this.idAlbum > 0) {
      // Si se trata de una edición, carga los datos del álbum existente
      this.albumServicio.uno(this.idAlbum).subscribe((unalbum) => {
        this.frm_Album.controls['titulo'].setValue(unalbum.titulo);
        this.frm_Album.controls['genero'].setValue(unalbum.genero);
        this.frm_Album.controls['anio_lanzamiento'].setValue(unalbum.anio_lanzamiento);
        this.frm_Album.controls['discografica'].setValue(unalbum.discografica);

        this.titulo = 'Editar Álbum'; // Cambia el título a edición
      });
    }
  }

  // Método para grabar o actualizar el álbum
  grabar() {
    let album: IAlbum = {
      idAlbum: this.idAlbum,
      titulo: this.frm_Album.controls['titulo'].value,
      genero: this.frm_Album.controls['genero'].value,
      anio_lanzamiento: this.frm_Album.controls['anio_lanzamiento'].value,
      discografica: this.frm_Album.controls['discografica'].value
    };

    // Confirmación con SweetAlert antes de guardar el álbum
    Swal.fire({
      title: 'Álbumes',
      text: 'Desea guardar el álbum ' + this.frm_Album.controls['titulo'].value,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#f00',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Grabar!'
    }).then((result) => {
      if (result.isConfirmed) {
        if (this.idAlbum > 0) {
          // Si es una edición, actualiza el álbum
          this.albumServicio.actualizar(album).subscribe((res: any) => {
            Swal.fire({
              title: 'Álbumes',
              text: res.mensaje,
              icon: 'success'
            });
            this.navegacion.navigate(['/albumes']);
          });
        } else {
          // Si es un nuevo álbum, lo inserta
          this.albumServicio.insertar(album).subscribe((res: any) => {
            Swal.fire({
              title: 'Álbumes',
              text: res.mensaje,
              icon: 'success'
            });
            this.navegacion.navigate(['/albumes']);
          });
        }
      }
    });
  }
}
