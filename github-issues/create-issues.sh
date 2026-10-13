#!/usr/bin/env bash
set -euo pipefail

# ---------------------------------------------------------------------------
# Cara pakai:
#   1. Pastikan GitHub CLI terpasang & sudah login: `gh auth login`
#   2. `cd` ke folder clone repo KPMI Pekalongan kamu (remote origin sudah
#      mengarah ke GitHub). Jangan jalankan dari folder kpmi-issues/ ini.
#   3. Salin folder `docs/` dari kit ini ke root repo kamu (berisi
#      ARCHITECTURE.md yang dirujuk semua issue).
#   4. Jalankan: bash /path/ke/create-issues.sh
#
# Kalau mau eksplisit menunjuk repo lain (bukan dari direktori saat ini),
# isi REPO di bawah, misal REPO="namamu/kpmi-pekalongan", lalu uncomment
# baris REPO_FLAG.
# ---------------------------------------------------------------------------

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# REPO="namamu/kpmi-pekalongan"
# REPO_FLAG=(--repo "$REPO")
REPO_FLAG=()

echo "==> Membuat label..."
create_label () {
  local name="$1" color="$2" desc="$3"
  gh label create "$name" --color "$color" --description "$desc" "${REPO_FLAG[@]}" --force
}

create_label "fase-0-setup"            "6f42c1" "Fase 0 - Setup & konfigurasi awal"
create_label "fase-1-authentication"   "6f42c1" "Fase 1 - Authentication"
create_label "fase-2-member-directory" "6f42c1" "Fase 2 - Member Directory"
create_label "fase-3-roles-skill"      "6f42c1" "Fase 3 - Roles Profesi & Skill"
create_label "fase-4-businesses"       "6f42c1" "Fase 4 - Businesses"
create_label "fase-5-opportunities"    "6f42c1" "Fase 5 - Opportunities Board"
create_label "fase-6-referral"         "6f42c1" "Fase 6 - Referral"
create_label "fase-7-event"            "6f42c1" "Fase 7 - Event & Pendaftaran"
create_label "fase-8-dashboard-search" "6f42c1" "Fase 8 - Dashboard & Search/Filter"
create_label "fase-9-hardening-deploy" "6f42c1" "Fase 9 - Hardening & Deploy"
create_label "orchid"                  "0e8a16" "Terkait Orchid Screen/Panel"
create_label "public-area"             "0e8a16" "Terkait halaman publik (Laravel MVC)"
create_label "agent-ready"             "1d76db" "Konteks lengkap - cocok dikerjakan AI coding agent"
create_label "epic"                    "d93f0b" "Issue tracking, bukan task langsung dikerjakan"

echo "==> Membuat issue tiap fase..."
create_issue () {
  local title="$1" bodyfile="$2" labels="$3"
  gh issue create --title "$title" --body-file "$bodyfile" --label "$labels" "${REPO_FLAG[@]}" \
    | tee /tmp/kpmi_last_issue_url.txt
  grep -oE '[0-9]+$' /tmp/kpmi_last_issue_url.txt
}

NUM_0=$(create_issue "Fase 0 — Setup & Konfigurasi Awal" "$SCRIPT_DIR/fase-0-setup.md" "fase-0-setup,orchid,agent-ready")
NUM_1=$(create_issue "Fase 1 — Authentication" "$SCRIPT_DIR/fase-1-authentication.md" "fase-1-authentication,orchid,agent-ready")
NUM_2=$(create_issue "Fase 2 — Member Directory (Modul 1)" "$SCRIPT_DIR/fase-2-member-directory.md" "fase-2-member-directory,orchid,public-area,agent-ready")
NUM_3=$(create_issue "Fase 3 — Roles Profesi & Skill (Modul 2 & 3)" "$SCRIPT_DIR/fase-3-roles-skill.md" "fase-3-roles-skill,orchid,agent-ready")
NUM_4=$(create_issue "Fase 4 — Businesses (Modul 4)" "$SCRIPT_DIR/fase-4-businesses.md" "fase-4-businesses,orchid,public-area,agent-ready")
NUM_5=$(create_issue "Fase 5 — Opportunities Board (Modul 5)" "$SCRIPT_DIR/fase-5-opportunities.md" "fase-5-opportunities,orchid,agent-ready")
NUM_6=$(create_issue "Fase 6 — Referral (Modul 6)" "$SCRIPT_DIR/fase-6-referral.md" "fase-6-referral,orchid,agent-ready")
NUM_7=$(create_issue "Fase 7 — Event & Pendaftaran Event (Modul 7 & 8)" "$SCRIPT_DIR/fase-7-event.md" "fase-7-event,orchid,public-area,agent-ready")
NUM_8=$(create_issue "Fase 8 — Dashboard & Search/Filter Terpadu (Modul 9)" "$SCRIPT_DIR/fase-8-dashboard-search.md" "fase-8-dashboard-search,orchid,agent-ready")
NUM_9=$(create_issue "Fase 9 — Hardening & Deploy" "$SCRIPT_DIR/fase-9-hardening-deploy.md" "fase-9-hardening-deploy,agent-ready")

echo "==> Menutup issue Fase 1 (sudah dikerjakan)..."
gh issue close "$NUM_1" "${REPO_FLAG[@]}" \
  --comment "Kode sudah dikerjakan di luar repo (lihat riwayat percakapan arsitek/AI) dan tinggal di-commit lewat PR. Buka lagi issue ini kalau PR-nya belum ada." || true

echo "==> Membuat Epic tracking issue..."
EPIC_BODY="$(mktemp)"
cat > "$EPIC_BODY" <<EOF2
# KPMI Pekalongan — Roadmap Implementasi (Epic)

Melacak seluruh tahap pembangunan platform komunitas KPMI (Komunitas Pengusaha Muslim
Indonesia) chapter Pekalongan. Dokumen desain lengkap (analisis kebutuhan, ERD, struktur
folder, daftar migration & model): \`docs/ARCHITECTURE.md\`.

Stack: Laravel 13 + MariaDB + Orchid Platform + Eloquent. Admin & Member Area = satu Panel
Orchid (dibedakan Role/Permission), Public Area = Laravel MVC + Bootstrap 5.

## Checklist Fase
- [ ] Fase 0 — Setup Role & Konfigurasi Panel (#$NUM_0)
- [x] Fase 1 — Authentication (#$NUM_1, sudah dikerjakan)
- [ ] Fase 2 — Member Directory (#$NUM_2)
- [ ] Fase 3 — Roles Profesi & Skill (#$NUM_3)
- [ ] Fase 4 — Businesses (#$NUM_4)
- [ ] Fase 5 — Opportunities Board (#$NUM_5)
- [ ] Fase 6 — Referral (#$NUM_6)
- [ ] Fase 7 — Event & Pendaftaran Event (#$NUM_7)
- [ ] Fase 8 — Dashboard & Search/Filter (#$NUM_8)
- [ ] Fase 9 — Hardening & Deploy (#$NUM_9)

## Urutan pengerjaan
Sekuensial di awal (Fase 0 → 1 → 2), karena tiap fase butuh tabel/role dari fase sebelumnya.
Setelah Fase 2 selesai, Fase 3, 4, 5, 6 **bisa dikerjakan paralel** oleh kontributor atau AI
agent berbeda karena tidak saling bergantung. Fase 7 butuh Fase 2 selesai (relasi ke users).
Fase 8 sebaiknya menunggu Fase 2–7 selesai (butuh semua tabel untuk dashboard/search). Fase 9
paling akhir.

## Untuk kontributor & AI agent
Tiap issue fase sudah memuat konteks lengkap (stack, konvensi, checklist, definition of done)
supaya bisa dikerjakan tanpa perlu baca histori diskusi lain — cukup baca issue-nya +
\`docs/ARCHITECTURE.md\`.
EOF2

gh issue create --title "Epic: Roadmap Implementasi KPMI Pekalongan" --body-file "$EPIC_BODY" \
  --label "epic" "${REPO_FLAG[@]}"

echo "==> Selesai. Semua issue & epic berhasil dibuat."
