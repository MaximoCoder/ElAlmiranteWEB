<!-- CONTENT -->
	<!-- NAVBAR -->
	<nav>
		<i class='bx bx-menu'></i>
		<a href="#" class="nav-link">Categories</a>
		<form action="#">
			<div class="form-input">
				<input type="search" placeholder="Search...">
				<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
			</div>
		</form>
		<input type="checkbox" id="switch-mode" hidden>
		<label for="switch-mode" class="switch-mode"></label>
		
	</nav>
	<!-- NAVBAR -->


	<!-- MAIN -->
	<main>
		<div class="head-title">
			<div class="left">
				<h1>Dashboard</h1>
				<ul class="breadcrumb">
					<li>
						<a href="#">Dashboard</a>
					</li>
					<li><i class='bx bx-chevron-right'></i></li>
					<li>
						<a class="active" href="#">Home</a>
					</li>
				</ul>
			</div>
			<a href="#" class="btn-download">
				<i class='bx bxs-cloud-download'></i>
				<span class="text">Download PDF</span>
			</a>
		</div>

		<ul class="box-info">
			<li>
				<i class='bx bxs-calendar-check'></i>
				<span class="text">
					<h3><?= $newOrdenes['total']; ?></h3>
					<p>Nuevos Pedidos</p>
				</span>
			</li>
			<li>
				<i class='bx bxs-group'></i>
				<span class="text">
					<h3><?= $visitantesActivos; ?></h3>
					<p>Visitantes</p>
				</span>
			</li>
			<li>
				<i class='bx bxs-dollar-circle'></i>
				<span class="text">
					<h3>$<?= htmlspecialchars($Totalventas['total']); ?></h3>
					<p>Total Ventas</p>
				</span>
			</li>
		</ul>


		<div class="table-data">
			<div class="order">
				<div class="head">
					<h3>Pedidos de hoy</h3>
					<i class='bx bx-search'></i>
					<i class='bx bx-filter'></i>
				</div>
				<table>
					<thead>
						<tr>
							<th>User</th>
							<th>Date Order</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($ordenes)): ?>
							<?php foreach ($ordenes as $orden): ?>
								<tr>
									<td>
										
										<p><?= htmlspecialchars($orden['NombreCliente']); ?></p>
									</td>
									<td><?= htmlspecialchars(date('d-m-Y', strtotime($orden['FechaOrden']))); ?></td>
									<td>
										<span class="status text-black"
									<?= htmlspecialchars(strtolower($orden['EstadoOrden'])); ?>">
											<?= htmlspecialchars($orden['EstadoOrden']); ?>
										</span>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="6">Todavia no hay ninguna orden</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</main>
	<!-- MAIN -->

<!-- CONTENT -->