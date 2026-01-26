Este é um roadmap técnico detalhado, desenhado para orientar o desenvolvimento assistido por IA (Junie/JetBrains AI). Ele está estruturado para garantir que as regras de arquitetura (Hexagonal no Backend e Atomic/DDD no Frontend) sejam rigorosamente seguidas.

---

# 🗺️ Roadmap: Sistema de Gestão de Academia (Fight Club Management)

## 🏗️ Visão Geral da Arquitetura

*   **Frontend:** Next.js (App Router), PWA, Atomic Design, DDD, Apollo Client (GraphQL), Framer Motion, Storybook.
*   **Backend:** Laravel, Lighthouse PHP (GraphQL), Arquitetura Hexagonal, Sanctum (Auth).

---

## 📅 Fase 1: Fundação e Configuração de Ambientes

O objetivo é preparar o terreno para que a IA possa gerar código dentro dos padrões estritos.

### 1.1. Backend (Laravel - Hexagonal Setup)
*   **Instalação:** Laravel 11+ e Lighthouse PHP.
*   **Estrutura de Pastas (Hexagonal):**
    *   `src/Core/Domain`: Entidades puras (PHP classes), Value Objects (ex: `Money`, `PhoneNumber`), Interfaces de Repositórios. *Zero dependência do Laravel.*
    *   `src/Core/Application`: Use Cases (Services), DTOs input/output.
    *   `src/Infrastructure`: Implementações do Laravel (Models Eloquent, Jobs, Mailers).
    *   `src/Infrastructure/Adapters`: Implementação das Interfaces de Repositório do Domain usando Eloquent.
*   **Configuração GraphQL:** Instalar Lighthouse, configurar Schema base.
*   **Database:** Migrations para usuários (UUID primary key, `phone_number` unique).

### 1.2. Frontend (Next.js - Atomic + DDD)
*   **Setup:** Next.js 14+, TypeScript, TailwindCSS.
*   **Estrutura de Pastas (Rigidez):**
    *   `src/ui/base`: (Botões, Inputs, Icons).
    *   `src/ui/composed`: (Cards complexos, Formulários sem lógica de negócio).
    *   `src/ui/layouts`: (Grid, Sidebar, MobileWrappers).
    *   `src/domain`: (Lógica de negócio - Ex: `Student`, `Class`).
    *   `src/services`: (API calls, formatters).
    *   `src/providers`: (Contexts, Apollo Provider).
*   **Tooling:** Storybook configurado para ler `src/ui/**/*.stories.tsx`. Jest/Vitest setup.
*   **PWA:** `next-pwa` ou configuração manual de manifest e service worker.

---

## 🏃 Fase 2: Autenticação e Gestão de Identidade (Fluxo Crítico)

Como a entrada é via WhatsApp, o login deve ser "passwordless" ou simplificado.

### 2.1. Backend (Auth & Roles)
*   **Core:** Entidade `User` com Value Object `PhoneNumber`.
*   **Infra:** Integração com serviço de SMS (ex: Twilio/Zenvia) ou Mock para dev.
*   **Auth Flow:**
    1.  Mutation `requestLoginCode(phone: String!)`.
    2.  Mutation `verifyLoginCode(phone: String!, code: String!)` -> Retorna Token (Sanctum).
*   **Roles:** Middleware para proteger rotas (Admin, Professor, Aluno).
*   **GraphQL:** Custom Directive `@auth` e `@role`.

### 2.2. Frontend (Login Mobile-First)
*   **UI:** Criar `InputPhone`, `InputOTP` em `src/ui/base`.
*   **Domain:** `src/domain/Auth`.
*   **Logica:** Otimistic UI ao enviar o código (feedback visual imediato).
*   **Motion:** Animação de transição entre tela de telefone e tela de código.

---

## 🥋 Fase 3: Domínio Acadêmico (Alunos e Modalidades)

### 3.1. Backend (Cadastro e Lógica)
*   **Modalidades:** Boxe, Muay Thai, Jiu-Jitsu, etc. (Tabela referencial).
*   **Use Cases:** `RegisterStudent`, `AssignPlan`, `UpdateStudentProgress`.
*   **Data Formatting:** Campo `price` no banco é `integer` (centavos).
    *   *Resolver GraphQL:* Transformar int em string formatada "R$ 150,00" na saída.
*   **UUID:** Garantir que tudo use UUIDs.

### 3.2. Frontend (Dashboard do Aluno)
*   **Atomic:** `CardPlan`, `ProgressBar` (para graduação).
*   **Feature:** Visualização da graduação atual (faixa/grau).
*   **UX:** O aluno entra pelo link do WhatsApp -> Cai direto no Dashboard personalizado.

---

## 💰 Fase 4: Financeiro e Assinaturas

### 4.1. Backend
*   **Core:** Entidade `Payment`, `Subscription`. Regras de vencimento.
*   **Infra:** CronJob para checar vencimentos e gerar notificações (lembretes).
*   **GraphQL:** Query `myPayments` e Mutation `markAsPaid` (Admin/Prof).

### 4.2. Frontend
*   **UI:** Lista de pagamentos com status (Pendente = Amarelo, Pago = Verde, Atrasado = Vermelho).
*   **Service:** Lógica para lidar com conversão se necessário (embora o back já mande formatado, o front pode precisar do int para cálculos).

---

## 📅 Fase 5: Agenda, Frequência e Professores

### 5.1. Backend
*   **Core:** Entidade `ClassSession`, `Attendance`.
*   **Lógica:** Professor vê apenas suas turmas. Admin vê tudo.
*   **Calculo:** Dinheiro a receber por professor (se for comissão por aluno ou aula).

### 5.2. Frontend
*   **Feature:** Check-in.
    *   *Geolocalização (Opcional):* Validar se o aluno está na academia.
*   **UI:** Calendário de eventos (Workshops, Graduações).
*   **Admin/Prof View:** Lista de chamada digital (fácil toque no celular).

---

## 🚀 Fase 6: Refinamento UX, Analytics e Deploy

### 6.1. PWA & Performance
*   Configurar `manifest.json` com ícones corretos.
*   Testar instalação no iOS e Android.
*   Implementar `SpeedInsights` da Vercel.

### 6.2. Motion & Polish
*   Usar `framer-motion` para transições de página e micro-interações (ex: check de presença animado).
*   Garantir acessibilidade (A11y).

### 6.3. Deploy
*   **Frontend:** Vercel (CD automático via Git).
*   **Backend:** Hostinger. Configurar Pipeline de Deploy (GitHub Actions para FTP ou SSH git pull).

---

## 🤖 Guia de Prompts para a IA (Junie)

Para obter os melhores resultados, utilize estes templates de prompt em cada fase:

### Template: Criando Componente UI (Frontend)
> "Crie um componente atômico chamado `Button` em `src/ui/base/Button`.
> Requisitos:
> 1. Deve ter variantes 'primary', 'secondary', 'danger'.
> 2. Deve usar TailwindCSS.
> 3. Crie o arquivo `index.ts`, `Button.tsx`, `Button.test.tsx` (Testing Library) e `Button.stories.tsx`.
> 4. O design deve ser Mobile-First (touch targets de min 44px).
> 5. Documente o uso no `src/ui/README.mdx`."

### Template: Criando Lógica de Domínio (Frontend)
> "Preciso implementar a listagem de turmas em `src/domain/Classes`.
> 1. Crie um Service `src/services/classService.ts` que consome a Query GraphQL `GET_CLASSES`.
> 2. Crie um Hook customizado em `src/domain/Classes/hooks/useClasses.ts`.
> 3. Utilize Optimistic UI para a ação de 'Check-in'.
> 4. O componente de UI deve estar em `src/domain/Classes/components/ClassList.tsx`, utilizando componentes base de `src/ui`."

### Template: Criando Use Case (Backend Hexagonal)
> "Crie o caso de uso `RegisterStudent` seguindo Arquitetura Hexagonal.
> 1. **Core/Domain:** Crie a entidade `Student` e a interface `StudentRepositoryInterface`.
> 2. **Core/Application:** Crie o Service `RegisterStudentService` que recebe um DTO.
> 3. **Infrastructure:** Implemente `EloquentStudentRepository` que usa o Model do Laravel.
> 4. Crie a Mutation GraphQL `registerStudent` que injeta o Service.
> 5. O preço da mensalidade deve ser salvo como inteiro (cents) mas retornado formatado no GraphQL Type."

---

## 📂 Estrutura de Diretórios Resumo

### Frontend (Next.js)
```text
src/
├── domain/            # Regras de Negócio (DDD)
│   ├── Auth/
│   ├── Student/
│   └── Financial/
├── services/          # Fetchers, API, Utils puros
├── providers/         # Contexts, Bridges
├── ui/                # Design System Atomicista
│   ├── base/          # Icon, Button, Typography
│   ├── composed/      # Header, Navbar, UserCard
│   ├── layouts/       # MainLayout, AuthLayout
│   └── README.mdx     # Styleguide
└── app/               # Next.js App Router (Páginas)
```

### Backend (Laravel)
```text
app/
├── GraphQL/           # Schemas e Resolvers
├── Models/            # Eloquent Models (Infra apenas)
src/                   # Hexagonal Core
├── Core/
│   ├── Domain/        # Entities, ValueObjects, Exceptions
│   └── Application/   # Services, UseCases, DTOs
└── Infrastructure/
    ├── Adapters/      # Repository Implementations
    └── Services/      # Gateways (SMS, Payment)
```

Este roadmap cobre desde a configuração inicial até o deploy, garantindo que a IA tenha contexto suficiente para gerar código de alta qualidade arquitetural.