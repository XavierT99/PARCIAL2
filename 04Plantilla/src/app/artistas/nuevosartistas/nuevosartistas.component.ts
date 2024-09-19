import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { ArtistasService } from 'src/app/Services/artistas.service';
import { IArtista } from 'src/app/Interfaces/iartista';
import { CommonModule } from '@angular/common';
import Swal from 'sweetalert2';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-nuevoartista',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule],
  templateUrl: './nuevoartista.component.html',
  styleUrls: ['./nuevoartista.component.scss']
})
export class NuevoArtistaComponent implements OnInit {
  frm_Artista = new FormGroup({
    nombre: new FormControl('', Validators.required),
    genero: new FormControl('', Validators.required),
    pais: new FormControl('', Validators.required)
  });

  idArtista = 0;
  titulo = 'Nuevo Artista';

  constructor(
    private artistaServicio: ArtistasService,
    private navegacion: Router,
    private ruta: ActivatedRoute
  ) {}

  ngOnInit(): void {
    this.idArtista = parseInt(this.ruta.snapshot.paramMap.get('idArtista'));
    if (this.idArtista > 0) {
      this.artistaServicio.uno(this.idArtista).subscribe((unartista) => {
        this.frm_Artista.controls['nombre'].setValue(unartista.nombre);
        this.frm_Artista.controls['genero'].setValue(unartista.genero);
        this.frm_Artista.controls['pais'].setValue(unartista.pais);
        this.titulo = 'Editar Artista';
      });
    }
  }

  grabar() {
    let artista: IArtista = {
      idArtista: this.idArtista,
      nombre: this.frm_Artista.controls['nombre'].value,
      genero: this.frm_Artista.controls['genero'].value,
      pais: this.frm_Artista.controls['pais'].value
    };

    Swal.fire({
      title: 'Artistas',
      text: '¿Desea guardar al artista ' + this.frm_Artista.controls['nombre'].value + '?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#f00',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Grabar!'
    }).then((result) => {
      if (result.isConfirmed) {
        if (this.idArtista > 0) {
          this.artistaServicio.actualizar(artista).subscribe((res: any) => {
            Swal.fire({
              title: 'Artistas',
              text: res.mensaje,
              icon: 'success'
            });
            this.navegacion.navigate(['/artistas']);
          });
        } else {
          this.artistaServicio.insertar(artista).subscribe((res: any) => {
            Swal.fire({
              title: 'Artistas',
              text: res.mensaje,
              icon: 'success'
            });
            this.navegacion.navigate(['/artistas']);
          });
        }
      }
    });
  }
}
