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

**TD3 & TD4 - Directus et** 

  

  

  

  

  

  

  

# TD3 - Mise en place de Directus

  

Objectif

Installer Directus via Docker et créer le modèle de données pour l'application de gestion de praticiens.

  

Configuration Docker:

  

Le fichier \`docker-compose.yml\` configure deux services (voir fichier dans le repo)

  

# TD4 - Requêtes 

  

 Partie 1 : Requêtes Query de base

  

Cette section présente les requêtes de consultation de données via .

  

  

  

**Question 1 : Liste simple des praticiens**

  

Objectif : Récupérer les informations de base de tous les praticiens.

  

Requête  :

query {

  praticiens {

    id

    nom

    prenom

    telephone

    ville

  }

}

  

  

Réponse obtenue :

json

{

  "data": {

    "praticiens": \[

      {

        "id": "4305f5e9-be5a-4ccf-8792-7e07d7017363",

        "nom": "Radio Plus",

        "prenom": "Cabinet",

        "telephone": "03 43 56 65 54",

        "ville": "Nancy"

      },

      {

        "id": "8236bcbf-4c06-3d0e-8ab0-c4964e02c4ea",

        "nom": "Pichon",

        "prenom": "Arnaude",

        "telephone": "06 61 50 63 81",

        "ville": "Paris"

      },

      {

        "id": "8ae1400f-d46d-3b50-b356-269f776be532",

        "nom": "Klein",

        "prenom": "Gabrielle",

        "telephone": "+33 03 90 27 98 80",

        "ville": "Paris"

      },

      {

        "id": "af7bb2f1-cc52-3388-b9bc-c0b89e7f4c5b",

        "nom": "Paul",

        "prenom": "Marine",

        "telephone": "02 36 11 25 88",

        "ville": "Paris"

      },

      {

        "id": "b994a36f-794f-3ddc-b267-99673661466d",

        "nom": "Guichard",

        "prenom": "Laurence",

        "telephone": "+33 8 99 14 03 98",

        "ville": "Paris"

      }

    \]

  }

}

  

  

Analyse : 5 praticiens récupérés, situés à Paris et Nancy.

  

  

  

 📌 Question 2 : Ajouter la spécialité

  

Objectif : Enrichir les données avec le libellé de la spécialité de chaque praticien.

  

Requête  :

  

query {

  praticiens {

    id

    nom

    prenom

    telephone

    ville

    specialite {

      libelle

    }

  }

}

  

  

Réponse obtenue :

json

{

  "data": {

    "praticiens": \[

      {

        "id": "4305f5e9-be5a-4ccf-8792-7e07d7017363",

        "nom": "Radio Plus",

        "prenom": "Cabinet",

        "telephone": "03 43 56 65 54",

        "ville": "Nancy",

        "specialite": {

          "libelle": "Consultation"

        }

      },

      {

        "id": "8236bcbf-4c06-3d0e-8ab0-c4964e02c4ea",

        "nom": "Pichon",

        "prenom": "Arnaude",

        "telephone": "06 61 50 63 81",

        "ville": "Paris",

        "specialite": {

          "libelle": "Médecine du sport"

        }

      },

      {

        "id": "8ae1400f-d46d-3b50-b356-269f776be532",

        "nom": "Klein",

        "prenom": "Gabrielle",

        "telephone": "+33 03 90 27 98 80",

        "ville": "Paris",

        "specialite": null

      },

      {

        "id": "af7bb2f1-cc52-3388-b9bc-c0b89e7f4c5b",

        "nom": "Paul",

        "prenom": "Marine",

        "telephone": "02 36 11 25 88",

        "ville": "Paris",

        "specialite": null

      },

      {

        "id": "b994a36f-794f-3ddc-b267-99673661466d",

        "nom": "Guichard",

        "prenom": "Laurence",

        "telephone": "+33 8 99 14 03 98",

        "ville": "Paris",

        "specialite": null

      }

    \]

  }

}

  

  

Observation : Certains praticiens n'ont pas de spécialité (valeur \`null\`).

  

  

  

 📌 Question 3 : Filtrer par ville

  

Objectif : Ne récupérer que les praticiens installés à Paris.

  

Requête  :

  

query {

  praticiens(filter: { ville: { \_eq: "Paris" } }) {

    id

    nom

    prenom

    telephone

    ville

    specialite {

      libelle

    }

  }

}

  

  

Réponse obtenue :

json

{

  "data": {

    "praticiens": \[

      {

        "id": "8236bcbf-4c06-3d0e-8ab0-c4964e02c4ea",

        "nom": "Pichon",

        "prenom": "Arnaude",

        "telephone": "06 61 50 63 81",

        "ville": "Paris",

        "specialite": {

          "libelle": "Médecine du sport"

        }

      },

      {

        "id": "8ae1400f-d46d-3b50-b356-269f776be532",

        "nom": "Klein",

        "prenom": "Gabrielle",

        "telephone": "+33 03 90 27 98 80",

        "ville": "Paris",

        "specialite": null

      },

      {

        "id": "af7bb2f1-cc52-3388-b9bc-c0b89e7f4c5b",

        "nom": "Paul",

        "prenom": "Marine",

        "telephone": "02 36 11 25 88",

        "ville": "Paris",

        "specialite": null

      },

      {

        "id": "b994a36f-794f-3ddc-b267-99673661466d",

        "nom": "Guichard",

        "prenom": "Laurence",

        "telephone": "+33 8 99 14 03 98",

        "ville": "Paris",

        "specialite": null

      }

    \]

  }

}

  

  

Analyse : 4 praticiens parisiens identifiés. Opérateur utilisé : \`\_eq\` (égalité stricte).

  

  

  

 📌 Question 4 : Ajouter la structure d'appartenance

  

Objectif : Afficher le nom et la ville de la structure où exerce chaque praticien.

  

Requête  :

  

query {

  praticiens(filter: { ville: { \_eq: "Paris" } }) {

    id

    nom

    prenom

    telephone

    ville

    specialite {

      libelle

    }

    structure {

      nom

      ville

    }

  }

}

  

  

Réponse obtenue :

json

{

  "data": {

    "praticiens": \[

      {

        "id": "8236bcbf-4c06-3d0e-8ab0-c4964e02c4ea",

        "nom": "Pichon",

        "prenom": "Arnaude",

        "telephone": "06 61 50 63 81",

        "ville": "Paris",

        "specialite": {

          "libelle": "Médecine du sport"

        },

        "structure": {

          "nom": "Urgences Marin",

          "ville": "Bourdon-les-Bains"

        }

      },

      {

        "id": "8ae1400f-d46d-3b50-b356-269f776be532",

        "nom": "Klein",

        "prenom": "Gabrielle",

        "telephone": "+33 03 90 27 98 80",

        "ville": "Paris",

        "specialite": null,

        "structure": null

      },

      {

        "id": "af7bb2f1-cc52-3388-b9bc-c0b89e7f4c5b",

        "nom": "Paul",

        "prenom": "Marine",

        "telephone": "02 36 11 25 88",

        "ville": "Paris",

        "specialite": null,

        "structure": null

      },

      {

        "id": "b994a36f-794f-3ddc-b267-99673661466d",

        "nom": "Guichard",

        "prenom": "Laurence",

        "telephone": "+33 8 99 14 03 98",

        "ville": "Paris",

        "specialite": null,

        "structure": null

      }

    \]

  }

}

  

  

Observation : Seul 1 praticien sur 4 est rattaché à une structure.

  

  

  

 📌 Question 5 : Filtrer par email

  

Objectif : Combiner deux filtres - ville = Paris ET email contenant ".fr".

  

Requête  :

  

query {

  praticiens(

    filter: {

      ville: { \_eq: "Paris" }

      email: { \_contains: ".fr" }

    }

  ) {

    id

    nom

    prenom

    telephone

    ville

    email

    specialite {

      libelle

    }

    structure {

      nom

      ville

    }

  }

}

  

  

Réponse obtenue :

json

{

  "data": {

    "praticiens": \[

      {

        "id": "8236bcbf-4c06-3d0e-8ab0-c4964e02c4ea",

        "nom": "Pichon",

        "prenom": "Arnaude",

        "telephone": "06 61 50 63 81",

        "ville": "Paris",

        "email": "Arnaude.Pichon@yahoo.fr",

        "specialite": {

          "libelle": "Médecine du sport"

        },

        "structure": {

          "nom": "Urgences Marin",

          "ville": "Bourdon-les-Bains"

        }

      },

      {

        "id": "af7bb2f1-cc52-3388-b9bc-c0b89e7f4c5b",

        "nom": "Paul",

        "prenom": "Marine",

        "telephone": "02 36 11 25 88",

        "ville": "Paris",

        "email": "Marine.Paul@hotmail.fr",

        "specialite": null,

        "structure": null

      },

      {

        "id": "b994a36f-794f-3ddc-b267-99673661466d",

        "nom": "Guichard",

        "prenom": "Laurence",

        "telephone": "+33 8 99 14 03 98",

        "ville": "Paris",

        "email": "Laurence.Guichard@club-internet.fr",

        "specialite": null,

        "structure": null

      }

    \]

  }

}

  

  

Analyse : 3 praticiens avec des emails en .fr. Opérateur utilisé : \`\_contains\` (contient une sous-chaîne).

  

  

  

 📌 Question 6 : Filtrer sur une relation

  

Objectif : Trouver les praticiens rattachés à une structure située à Paris.

  

Requête  :

  

query {

  praticiens(

    filter: {

      structure: {

        ville: { \_eq: "Paris" }

      }

    }

  ) {

    id

    nom

    prenom

    telephone

    ville

    email

    specialite {

      libelle

    }

    structure {

      nom

      ville

    }

  }

}

  

  

Réponse obtenue :

json

{

  "data": {

    "praticiens": \[

      {

        "id": "4305f5e9-be5a-4ccf-8792-7e07d7017363",

        "nom": "Radio Plus",

        "prenom": "Cabinet",

        "telephone": "03 43 56 65 54",

        "ville": "Nancy",

        "email": "radio.plus@sante.fr",

        "specialite": {

          "libelle": "Consultation"

        },

        "structure": {

          "nom": "Cabinet Bigot",

          "ville": "Paris"

        }

      }

    \]

  }

}

  

  

Analyse : 1 praticien trouvé. Point clé : Le filtre porte sur une propriété de la relation (\`structure.ville\`).

  

  

  

 📌 Question 7 : Utilisation d'alias

  

Objectif : Récupérer deux listes distinctes dans une seule requête (praticiens de Paris et de Bourdon-les-Bains).

  

Requête  :

  

query {

  praticiensParis: praticiens(filter: { ville: { \_eq: "Paris" } }) {

    id

    nom

    prenom

    telephone

    ville

    specialite {

      libelle

    }

  }

  praticiensBourdon: praticiens(filter: { ville: { \_eq: "Bourdon-les-Bains" } }) {

    id

    nom

    prenom

    telephone

    ville

    specialite {

      libelle

    }

  }

}

  

  

Réponse obtenue :

json

{

  "data": {

    "praticiensParis": \[

      {

        "id": "8236bcbf-4c06-3d0e-8ab0-c4964e02c4ea",

        "nom": "Pichon",

        "prenom": "Arnaude",

        "telephone": "06 61 50 63 81",

        "ville": "Paris",

        "specialite": {

          "libelle": "Médecine du sport"

        }

      },

      {

        "id": "8ae1400f-d46d-3b50-b356-269f776be532",

        "nom": "Klein",

        "prenom": "Gabrielle",

        "telephone": "+33 03 90 27 98 80",

        "ville": "Paris",

        "specialite": null

      },

      {

        "id": "af7bb2f1-cc52-3388-b9bc-c0b89e7f4c5b",

        "nom": "Paul",

        "prenom": "Marine",

        "telephone": "02 36 11 25 88",

        "ville": "Paris",

        "specialite": null

      },

      {

        "id": "b994a36f-794f-3ddc-b267-99673661466d",

        "nom": "Guichard",

        "prenom": "Laurence",

        "telephone": "+33 8 99 14 03 98",

        "ville": "Paris",

        "specialite": null

      }

    \],

    "praticiensBourdon": \[\]

  }

}

  

  

Analyse : 4 praticiens à Paris, 0 à Bourdon-les-Bains. Avantage : Une seule requête pour plusieurs ensembles de données.

  

  

  

 📌 Question 8 : Utilisation de fragments

  

Objectif : Éviter la répétition de code en définissant un fragment réutilisable.

  

Requête  :

  

fragment PraticienInfo on praticiens {

  id

  nom

  prenom

  telephone

  ville

  specialite {

    libelle

  }

}

  

query {

  praticiensParis: praticiens(filter: { ville: { \_eq: "Paris" } }) {

    ...PraticienInfo

  }

  praticiensBourdon: praticiens(filter: { ville: { \_eq: "Bourdon-les-Bains" } }) {

    ...PraticienInfo

  }

}

  

  

Réponse obtenue :

json

{

  "data": {

    "praticiensParis": \[

      {

        "id": "8236bcbf-4c06-3d0e-8ab0-c4964e02c4ea",

        "nom": "Pichon",

        "prenom": "Arnaude",

        "telephone": "06 61 50 63 81",

        "ville": "Paris",

        "specialite": {

          "libelle": "Médecine du sport"

        }

      },

      {

        "id": "8ae1400f-d46d-3b50-b356-269f776be532",

        "nom": "Klein",

        "prenom": "Gabrielle",

        "telephone": "+33 03 90 27 98 80",

        "ville": "Paris",

        "specialite": null

      },

      {

        "id": "af7bb2f1-cc52-3388-b9bc-c0b89e7f4c5b",

        "nom": "Paul",

        "prenom": "Marine",

        "telephone": "02 36 11 25 88",

        "ville": "Paris",

        "specialite": null

      },

      {

        "id": "b994a36f-794f-3ddc-b267-99673661466d",

        "nom": "Guichard",

        "prenom": "Laurence",

        "telephone": "+33 8 99 14 03 98",

        "ville": "Paris",

        "specialite": null

      }

    \],

    "praticiensBourdon": \[\]

  }

}

  

  

Point important : Le fragment doit être déclaré avant la requête qui l'utilise. Avantage : Code plus maintenable et lisible.

  

  

  

 📌 Question 9 : Paramétrage avec variables

  

Objectif : Rendre la requête réutilisable en paramétrant la ville.

  

Requête  :

  

query PraticiensParVille($ville: String!) {

  praticiens(filter: { ville: { \_eq: $ville } }) {

    id

    nom

    prenom

    telephone

    ville

    specialite {

      libelle

    }

  }

}

  

  

Variables à passer (onglet Variables du client) :

json

{

  "ville": "Paris"

}

  

  

Réponse obtenue : (identique à la Question 3)

  

Avantage : Une seule requête pour interroger différentes villes sans modifier le code .

  

  

  

 📌 Question 10 : Requête inversée (structures → praticiens)

  

Objectif : Lister les structures avec leurs praticiens rattachés.

  

Requête  :

  

query {

  structures {

    nom

    ville

    praticiens {

      nom

      prenom

      email

      specialite {

        libelle

      }

    }

  }

}

  

  

Réponse obtenue (extrait) :

json

{

  "data": {

    "structures": \[

      {

        "nom": "Pichon Santé",

        "ville": "Diaz-sur-Boulanger",

        "praticiens": \[\]

      },

      {

        "nom": "Cabinet Bigot",

        "ville": "Paris",

        "praticiens": \[

          {

            "nom": "Radio Plus",

            "prenom": "Cabinet",

            "email": "radio.plus@sante.fr",

            "specialite": {

              "libelle": "Consultation"

            }

          }

        \]

      },

      {

        "nom": "Cabinet Toussaint Marechal",

        "ville": "Joubert",

        "praticiens": \[\]

      },

      {

        "nom": "Fischer Médecins",

        "ville": "83 place de Lefort",

        "praticiens": \[\]

      },

      {

        "nom": "Maison de Santé de Care-Sur\_Turpin",

        "ville": "Carre-sur-Turpin",

        "praticiens": \[\]

      },

      {

        "nom": "Urgences Marin",

        "ville": "Bourdon-les-Bains",

        "praticiens": \[

          {

            "nom": "Pichon",

            "prenom": "Arnaude",

            "email": "Arnaude.Pichon@yahoo.fr",

            "specialite": {

              "libelle": "Médecine du sport"

            }

          }

        \]

      },

      {

        "nom": "Maison Médiacle Parent - Lucas",

        "ville": "Lucas",

        "praticiens": \[\]

      },

      {

        "nom": "Cabinet Médical Vaillant",

        "ville": "LemonnierBourg",

        "praticiens": \[\]

      },

      {

        "nom": "Maison Santé Lombard",

        "ville": "Paris-la-Forêt",

        "praticiens": \[\]

      },

      {

        "nom": "SOS Médecins Lefevre",

        "ville": "Lefevre",

        "praticiens": \[\]

      },

      {

        "nom": "Cabinet Médical Martineau",

        "ville": "Royer",

        "praticiens": \[\]

      },

      {

        "nom": "Babinet Antoine",

        "ville": "Moreno",

        "praticiens": \[\]

      },

      {

        "nom": "Radio Plus",

        "ville": "Nancy",

        "praticiens": \[\]

      },

      {

        "nom": "Urgences médicales Bouchet",

        "ville": "Bouchet",

        "praticiens": \[\]

      }

    \]

  }

}

  

  

Analyse : 14 structures listées, seules 2 structures ont des praticiens rattachés.

  

  

  

 Partie 2 : Gestion des autorisations

  

 Configuration des rôles et utilisateurs

  

 Étape 1 : Créer un rôle "API User"

  

Chemin : Settings → Access Control → Roles → Create Role

  

Configuration :

\- Nom : \`API User\`

\- Permissions :

  - ✅ Read (lecture) sur toutes les collections

  - ✅ Create (création) sur praticiens et specialites

  - ✅ Update (modification) sur praticiens et specialites

  - ✅ Delete (suppression) sur praticiens et specialites

  

  

  

 Étape 2 : Créer deux utilisateurs

  

Utilisateur 1 - Token statique

\- Email : \`user-static@test.com\`

\- Password : \`password123\`

\- Rôle : API User

\- Token : Généré dans Access Tokens (type Static)

  

Utilisateur 2 - Token JWT

\- Email : \`user-jwt@test.com\`

\- Password : \`password123\`

\- Rôle : API User

\- Token : Obtenu via \`/auth/login\`

  

  

  

 Étape 3 : Restreindre l'accès public

  

Action : Retirer les droits de lecture du rôle "Public" sur :

\- \`motifs\_visite\`

\- \`moyens\_paiement\`

  

Effet : Ces collections ne sont plus accessibles sans authentification.

  

  

  

 Test des autorisations

  

 🔒 Requête 1 : Moyens de paiement (Token statique)

  

Sans authentification - Requête :

  

query {

  moyens\_paiement {

    id

    libelle

  }

}

  

  

Réponse (ERREUR) :

json

{

  "errors": \[

    {

      "message": " validation error.",

      "extensions": {

        "errors": \[

          {

            "message": "Cannot query field \\"moyens\_paiement\\" on type \\"Query\\".",

            "locations": \[

              {

                "line": 2,

                "column": 3

              }

            \]

          }

        \],

        "code": "\_VALIDATION"

      }

    }

  \]

}

  

  

Avec authentification (Header) :

  

Authorization: Bearer VOTRE\_TOKEN\_STATIQUE

  

  

Requête  :

  

query {

  moyens\_paiement {

    id

    libelle

  }

}

  

  

Réponse (SUCCÈS) :

json

{

  "data": {

    "moyens\_paiement": \[

      {

        "id": "1",

        "libelle": "espèces"

      },

      {

        "id": "2",

        "libelle": "chèque"

      },

      {

        "id": "3",

        "libelle": "carte bancaire"

      },

      {

        "id": "4",

        "libelle": "paypal"

      },

      {

        "id": "5",

        "libelle": "virement"

      }

    \]

  }

}

  

  

  

  

 🔒 Requête 2 : Spécialités avec motifs (Token JWT)

  

Obtenir le token JWT :

http

POST http://localhost:8055/auth/login

Content-Type: application/json

  

{

  "email": "user-jwt@test.com",

  "password": "password123"

}

  

  

Sans authentification - Requête :

  

query {

  specialites {

    id

    libelle

    motifs\_visite {

      id

      libelle

    }

  }

}

  

  

Réponse (ERREUR) : Similaire à la requête 1

  

Avec authentification (Header) :

  

Authorization: Bearer VOTRE\_JWT\_ACCESS\_TOKEN

  

  

Requête  :

  

query {

  specialites {

    id

    libelle

    motifs\_visite {

      id

      libelle

    }

  }

}

  

  

Réponse (SUCCÈS) :

json

{

  "data": {

    "specialites": \[

      {

        "id": "1",

        "libelle": "Consultation",

        "motifs\_visite": \[\]

      },

      {

        "id": "2",

        "libelle": "Renouvellement de traitement",

        "motifs\_visite": \[\]

      },

      {

        "id": "3",

        "libelle": "Médecine du sport",

        "motifs\_visite": \[\]

      },

      {

        "id": "4",

        "libelle": "Enfants",

        "motifs\_visite": \[\]

      },

      {

        "id": "5",

        "libelle": "radiologie",

        "motifs\_visite": \[\]

      },

      {

        "id": "6",

        "libelle": "cardiologie",

        "motifs\_visite": \[\]

      }

    \]

  }

}

  

  

  

  

 Partie 3 : Mutations 

  

Les mutations permettent de créer, modifier et supprimer des données.

  

  

  

 ➕ Mutation

  

## **Mutation 1 : Créer la spécialité "cardiologie"**

  

mutation {

  create\_specialites\_item(data: {

    libelle: "cardiologie"

  }) {

    id

    libelle

  }

}

  

réponse:

{

    "data": {

        "create\_specialites\_item": {

            "id": "6",

            "libelle": "cardiologie"

        }

    }

}

  

## **Mutation 2 : Créer un praticien**

  

mutation {

  create\_praticiens\_item(data: {

    nom: "Dubois"

    prenom: "Marie"

    ville: "Lyon"

    email: "marie.dubois@example.fr"

    telephone: "0612345678"

  }) {

    id

    nom

    prenom

    email

  }

}

réponse:

{

    "data": {

        "create\_praticiens\_item": {

            "id": "0c081841-46b0-407d-aab3-8de9835fc315",

            "nom": "Dubois",

            "prenom": "Marie",

            "email": "marie.dubois@example.fr"

        }

    }

}

  

## **Mutation 3 : Modifier le praticien pour le rattacher à "cardiologie"**

  

mutation {

  update\_praticiens\_item(

    id: "6"

    data: {

      specialite: {

        id: "6"

      }

    }

  ) {

    id

    nom

    prenom

    specialite {

      libelle

    }

  }

}

  

réponse:

{

    "data": {

        "update\_praticiens\_item": {

            "id": "0c081841-46b0-407d-aab3-8de9835fc315",

            "nom": "Dubois",

            "prenom": "Marie",

            "specialite": {

                "libelle": "cardiologie"

            }

        }

    }

}

  

## **Mutation 4 : Créer un praticien rattaché à "cardiologie"**

  

mutation {

  create\_praticiens\_item(data: {

    nom: "Martin"

    prenom: "Pierre"

    ville: "Marseille"

    email: "pierre.martin@example.fr"

    telephone: "0623456789"

    specialite: {

      id: "6"

    }

  }) {

    id

    nom

    prenom

    specialite {

      libelle

    }

  }

}

  

réponse:

{

    "data": {

        "create\_praticiens\_item": {

            "id": "2710c110-9371-4198-b1fe-b5c7a3c9ef83",

            "nom": "Martin",

            "prenom": "Pierre",

            "specialite": {

                "libelle": "cardiologie"

            }

        }

    }

}

  

  

Mutation 5 : Créer un praticien ET sa spécialité "chirurgie

  

**Étape 1 : Créer la spécialité "chirurgie"**

  

mutation {

  create\_specialites\_item(data: {

    libelle: "chirurgie"

  }) {

    id

    libelle

  }

}

**Étape 2 : Créer le praticien et le rattacher à cette spécialité**

mutation {

  create\_praticiens\_item(data: {

    nom: "Leroy"

    prenom: "Sophie"

    ville: "Toulouse"

    email: "sophie.leroy@example.fr"

    telephone: "0634567890"

    specialite: {

      id: "ID\_DE\_LA\_SPECIALITE\_CHIRURGIE\_CRÉÉE"

    }

  }) {

    id

    nom

    prenom

    specialite {

      id

      libelle

    }

  }

}

  

Mutation 6 : Ajouter un praticien à la spécialité "chirurgie”

  

mutation {

  create\_praticiens\_item(data: {

    nom: "Bernard"

    prenom: "Luc"

    ville: "Nice"

    email: "luc.bernard@example.fr"

    telephone: "0645678901"

    specialite: {

      id: "ID\_DE\_LA\_SPECIALITE\_CHIRURGIE"

    }

  }) {

    id

    nom

    prenom

    specialite {

      libelle

    }

  }

}

  

réponse:

{

    "data": {

        "create\_praticiens\_item": {

            "id": "8819d6bd-5c0c-44c3-80fc-89405a715fb5",

            "nom": "Bernard",

            "prenom": "Luc",

            "specialite": {

                "libelle": "chirurgie"

            }

        }

    }

}

  

Mutation 7 : Modifier le premier praticien pour le rattacher à une structure

mutation {

  update\_praticiens\_item(

    id: "ID\_DU\_PREMIER\_PRATICIEN"

    data: {

      structure: {

        id: "ID\_D\_UNE\_STRUCTURE\_EXISTANTE"

      }

    }

  ) {

    id

    nom

    prenom

    structure {

      nom

      ville

    }

  }

}

  

réponse:

{

    "data": {

        "update\_praticiens\_item": {

            "id": "4305f5e9-be5a-4ccf-8792-7e07d7017363",

            "nom": "Radio Plus",

            "prenom": "Cabinet",

            "structure": {

                "nom": "\\tCabinet Bigot",

                "ville": "Paris"

            }

        }

    }

}

  

Mutation 8 : Supprimer les deux derniers praticiens créés

  

faire cette requete deux fois avec chaque id

mutation {

  delete\_praticiens\_item(id: "ID\_PRATICIEN") {

    id

  }

}

  

réponse d’un delete:

{

    "data": {

        "delete\_praticiens\_item": {

            "id": "b994a36f-794f-3ddc-b267-99673661466d"

        }

    }

}