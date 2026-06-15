import csv
import re
from collections import defaultdict
from io import StringIO


def natural_sort_key(s):
    return [int(text) if text.isdigit() else text.lower() for text in re.split(r'(\d+)', s)]


def analyze_csv(file):
    content = file.stream.read().decode("utf-8-sig")
    reader = csv.DictReader(StringIO(content))

    students_data = defaultdict(set)
    teacher_groups = defaultdict(lambda: defaultdict(set))
    class_counters = defaultdict(set)
    class_all_teachers = defaultdict(set)

    for row in reader:
        fio = row.get('ФИО обучающегося', '').strip()
        litera = row.get('Класс', '').strip()
        teacher = row.get('ФИО учителя', '').strip()
        if not fio or not litera or not teacher:
            continue
        students_data[(fio, litera)].add(teacher)
        teacher_groups[teacher][litera].add(fio)
        class_counters[litera].add(fio)
        class_all_teachers[litera].add(teacher)

    # =====================================================================
    # 🔥 АВТОМАТИЧЕСКИЙ АНАЛИЗ ПОДГРУПП ЛЮБОГО РАЗМЕРА
    # =====================================================================
    detected_subgroups = defaultdict(list)

    for cls, total_students_set in class_counters.items():
        teachers_in_class = list(class_all_teachers[cls])

        for i in range(len(teachers_in_class)):
            for j in range(i + 1, len(teachers_in_class)):
                t1 = teachers_in_class[i]
                t2 = teachers_in_class[j]

                students_t1 = teacher_groups[t1][cls]
                students_t2 = teacher_groups[t2][cls]

                intersection = students_t1.intersection(students_t2)

                # Условие подгрупп: общих детей нет, у каждого минимум по 3 ученика
                if len(intersection) == 0 and len(students_t1) >= 3 and len(students_t2) >= 3:
                    detected_subgroups[cls].append((t1, t2))

    # Считаем моду (самое частое кол-во учителей) по классу
    class_mode_teachers = {}
    for cls in class_counters:
        counts = defaultdict(int)
        for (fio, c), teachers in students_data.items():
            if c == cls:
                counts[len(teachers)] += 1
        mode = max(counts.items(), key=lambda x: (x[1], x[0]))[0]
        class_mode_teachers[cls] = mode

    # Полный набор учителей у учеников с модальным кол-вом
    class_full_teachers = defaultdict(set)
    for (fio, cls), teachers in students_data.items():
        if len(teachers) >= class_mode_teachers[cls]:
            class_full_teachers[cls].update(teachers)

    # Формируем список учеников с умным фильтром подгрупп
    students = []
    for (fio, cls), teachers in students_data.items():
        mode = class_mode_teachers[cls]

        if len(teachers) >= mode:
            missing = []
        else:
            raw_missing = class_full_teachers[cls] - teachers
            real_missing = set(raw_missing)

            # Применяем автоматический фильтр подгрупп
            subgroups = detected_subgroups[cls]
            for t1, t2 in subgroups:
                if t1 in raw_missing and t2 in teachers:
                    real_missing.discard(t1)
                if t2 in raw_missing and t1 in teachers:
                    real_missing.discard(t2)

            missing = sorted(list(real_missing))

        students.append({
            "class": cls,
            "student": fio,
            "teachers": ", ".join(sorted(teachers)),
            "teacher_count": len(teachers),
            "max_teachers": class_mode_teachers[cls],
            "missing_teachers": missing
        })

    # Группировка нагрузки по каждому учителю
    teachers_grouped = defaultdict(list)
    for teacher, classes in teacher_groups.items():
        for cls, pupils in classes.items():
            all_in_class = class_counters[cls]
            complete = len(pupils)
            incomplete = len(all_in_class) - complete

            teachers_grouped[teacher].append({
                "class": cls,
                "count": complete,
                "incomplete": incomplete
            })

    teachers_list = []
    for teacher, classes_data in teachers_grouped.items():
        teachers_list.append({
            "teacher": teacher,
            "classes": sorted(classes_data, key=lambda x: x["class"])
        })

    # Сводные данные по классам с именами учителей
    classes_list = []
    for cls in class_counters:
        classes_list.append({
            "class": cls,
            "students": len(class_counters[cls]),
            "teachers_list": sorted(list(class_all_teachers[cls]))
        })

    return {
        "students": sorted(students, key=lambda x: (natural_sort_key(x["class"]), x["student"])),
        "teachers": sorted(teachers_list, key=lambda x: x["teacher"]),
        "classes": sorted(classes_list, key=lambda x: natural_sort_key(x["class"]))
    }