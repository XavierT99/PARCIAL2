import { Component, OnInit } from '@angular/core';
import { RouterLink } from '@angular/router';
import { SharedModule } from 'src/app/theme/shared/shared.module';
import { IArtista } from '../Interfaces/iartista';
import { ArtistasService } from '../Services/artistas.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-artistas',
  standalone: true,
  imports: [RouterLink, SharedModule],
  templateUrl: './artistas.component.html',
  styleUrls: ['./artistas.component.scss']
})
export class ArtistasComponent implements OnInit {
  listaArtistas: IArtista[] = [];

  constructor(private artistaServicio: ArtistasService) {}

  ngOnInit() {
    this.cargarTabla();
  }

  cargarTabla() {
    this.artistaServicio.todos().subscribe((data) => {
      console.log(data);
      this.listaArtistas = data;
    });
  }

  eliminar(idArtista: number) {
    Swal.fire({
      title: 'Artistas',
      text: '¿Está seguro de que desea eliminar al artista?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Eliminar Artista'
    }).then((result) => {
      if (result.isConfirmed) {
        this.artistaServicio.eliminar(idArtista).subscribe((data) => {
          Swal.fire('Artistas', 'El artista ha sido eliminado.', 'success');
          this.cargarTabla();
        });
      }
    });
  }
}
