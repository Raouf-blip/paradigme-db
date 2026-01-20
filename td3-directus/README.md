# TD3 – API REST Directus

Base URL par défaut :

```
http://localhost:8055
```

Toutes les requêtes ci-dessous utilisent l’API REST de Directus.

---

## 1️⃣ Liste des praticiens

```http
GET /items/praticiens
```

---

## 2️⃣ La spécialité d’ID 2

```http
GET /items/specialites/2
```

---

## 3️⃣ La spécialité d’ID 2 avec uniquement son libellé

```http
GET /items/specialites/2?fields=libelle
```

---

## 4️⃣ Un praticien avec sa spécialité (libellé)

Exemple avec le praticien d’UUID 21f5a864-7b3b-43e3-b2ab-67b715e0e38c :

```http
GET /items/praticiens/21f5a864-7b3b-43e3-b2ab-67b715e0e38c?fields=nom,prenom,specialite.libelle
```

---

## 5️⃣ Une structure (nom, ville) et la liste des praticiens rattachés (nom, prénom)

Exemple avec la structure d’UUID 28395f58-e435-430e-847d-78cb5e506bbc :

```http
GET /items/structures/28395f58-e435-430e-847d-78cb5e506bbc?fields=nom,ville,praticiens.nom,praticiens.prenom
```

---

## 6️⃣ Idem en ajoutant le libellé de la spécialité des praticiens

```http
GET /items/structures/28395f58-e435-430e-847d-78cb5e506bbc?fields=nom,ville,praticiens.nom,praticiens.prenom,praticiens.specialite.libelle
```

---

## 7️⃣ Structures dont la ville contient "sur" avec la liste des praticiens

```http
GET /items/structures?filter[ville][_contains]=sur&fields=nom,ville,praticiens.nom,praticiens.prenom,praticiens.specialite.libelle
```

---